<?php

namespace core\classes\error;

use core\classes\mail\Mailer as SM;

/**
 * Description of Error
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class ErrorPHP
{
    /**
     *
     * @var object 
     */
    private $DBH = null;

    /**
     *
     * @var bool 
     */
    private $fileHandle = false;

    /**
     *
     * @var array 
     */
    private $errortypes = array(
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_NOTICE => "Notice",
        E_PARSE => "Parse",
        E_DEPRECATED => "Deprecated",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => "User Error",
        E_USER_WARNING => "User Warning",
        E_USER_NOTICE => "User Notice",
        E_USER_DEPRECATED => "User Deprecated",
        E_STRICT => 'Runtime Notice',
        E_ALL => 'All Errors'
    );

    public function __construct()
    {
        $this->init();
        $this->DBH = (isset($GLOBALS['DBM_PDO_INST']) ? $GLOBALS['DBM_PDO_INST']->getConnection() : null);
    }

    /**
     * @see https://www.php.net/manual/de/function.set-error-handler.php
     */
    private function init()
    {
        set_error_handler(array($this, "errorHandler"));

        if (!file_exists(DEBUG_LOG_FOLDER)) {
            mkdir(DEBUG_LOG_FOLDER, 0600);
        }
    }

    /**
     * Error handling
     * 
     * @param type $errorcode
     * @param type $errortext
     * @param type $errorfile
     * @param type $errorline
     */
    public function errorHandler($errorcode, $errortext, $errorfile, $errorline)
    {
        // Screen errors on website
        if (( in_array($errorcode, $GLOBALS['error-screen']) ) && ( DEBUG_DISPLAY === true )) {
            $output = "<fieldset class='error'>";
            $output .= "<legend class='errorInfo'>" . $this->errortypes[$errorcode] . "</legend>";
            $output .= "<b>Error:</b>&nbsp;" . $errortext . "<br><br>";
            $output .= "<b>File:</b>&nbsp;" . $errorfile . "&nbsp;<br><br>";
            $output .= "<b>Line:</b>&nbsp;<span class='errorInfo'>" . $errorline . "</span><br><br>";
            $output .= "</fieldset>";
            echo $output;
        }

        // Log errors in database
        if (in_array($errorcode, $GLOBALS['error-log']) && defined('DEBUG_DB_LOG') && DEBUG_DB_LOG === true) {
            $this->saveErrorLog($this->errortypes[$errorcode], $errortext, $errorfile, $errorline);
        }

        // Log errors in file
        if (in_array($errorcode, $GLOBALS['error-log']) && defined('DEBUG_LOG') && DEBUG_LOG === true) {
            $this->writeErrorLog($this->errortypes[$errorcode], $errortext, $errorfile, $errorline);
        }
        
        // Send errors per mail
        if (in_array($errorcode, $GLOBALS['error-mail']) && defined('DEBUG_MAIL_LOG') && DEBUG_MAIL_LOG === true) {
            $this->sendErrorLog($this->errortypes[$errorcode], $errortext, $errorfile, $errorline);
        }
    }

    /**
     * Save error in db
     * 
     * @param type $errortype
     * @param type $errormessage
     * @param type $errorfile
     * @param type $errorline
     */
    private function saveErrorLog($errortype, $errormessage, $errorfile, $errorline)
    {
        if ($this->DBH) {
            $errorDBlogSQL = "INSERT 
                                INTO `" . DB_PREFIX . "error` (type,error,script,line,created) 
                              VALUES(?,?,?,?,?)";
            $stmt = $this->DBH->prepare($errorDBlogSQL);

            $exec = $stmt->execute(array(
                $errortype,
                $errormessage,
                $errorfile,
                $errorline,
                time()
            ));

            if (!$exec) {
                if (defined('DEBUG_LOG') && DEBUG_LOG === true) {
                    $this->writeErrorLog('DB insert', 'exec faild', __FILE__, __LINE__);
                }
            }
        }
    }

    /**
     * Send error to admin
     * 
     * @param type $errortype
     * @param type $errormessage
     * @param type $errorfile
     * @param type $errorline
     */
    private function sendErrorLog($errortype, $errormessage, $errorfile, $errorline)
    {
        $error = '<h1>Error: </h1>';
        $error .= '<p>Type: ' . $errortype . '</p>';
        $error .= '<p>Message: ' . $errormessage . '</p>';
        $error .= '<p>File: ' . $errorfile . '</p>';
        $error .= '<p>Line: ' . $errorline . '</p>';
        $error .= '<p>Diese Email wurde automatisch vom System des ' . '' . ' generiert.</p>';
        $error .= '<p>--</p>';
        $error .= '<p><small>Administrator</small></p>';

        $simpleMailer = new SM();
        if (DEBUG_ADMIN_MAIL && !$simpleMailer->sendMail(DEBUG_ADMIN_MAIL, 'Test', $error)) {
            if (defined('DEBUG_LOG') && DEBUG_LOG === true) {
                $this->writeErrorLog('Send error', 'mail failed', __FILE__, __LINE__);
            }
        }
    }

    /**
     * Write error log file
     * 
     * @param type $errortype
     * @param type $errormessage
     * @param type $errorfile
     * @param type $errorline
     * 
     * @see https://www.php.net/manual/de/function.is-writable.php
     * @see http://php.net/manual/de/function.fopen.php
     * @see http://php.net/manual/de/function.fwrite.php
     * @see https://www.php.net/manual/de/function.is-resource.php
     * @see http://php.net/manual/de/function.fclose.php
     * @see https://www.php.net/manual/de/function.chmod.php
     */
    public function writeErrorLog($errortype, $errormessage, $errorfile, $errorline)
    {
        $error = "\r\n";
        $error .= "[" . date("d.m.Y - H:i:s", time()) . "]\r\n";
        $error .= $errortype . "\r\n";
        $error .= $errormessage . "\r\n";
        $error .= $errorfile . "\r\n";
        $error .= $errorline . "\r\n";

        if (file_exists(DEBUG_LOG_FILE) && !is_writable(DEBUG_LOG_FILE)) {
//            die('Error log file not writable: ' . DEBUG_LOG_FILE);
        }

        if (!$this->fileHandle = fopen(DEBUG_LOG_FILE, 'a+')) {
//            die('Can\'t open error log file: ' . DEBUG_LOG_FILE);
        }

        if (fwrite($this->fileHandle, $error) === FALSE) {
//            die('Can\'t write error log file: ' . DEBUG_LOG_FILE);
        }

        if (is_resource($this->fileHandle)) {
            fclose($this->fileHandle);
        } else {
//            die('Can\'t close error log file is not a resource: ' . DEBUG_LOG_FILE . PHP_EOL . $error);
        }
        
        chmod(DEBUG_LOG_FILE, 0600);
    }

}