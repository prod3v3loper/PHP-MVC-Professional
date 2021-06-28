<?php

declare(strict_types = 1);

namespace Aautoloder;

require_once "class.LoaderHelper.php";
require_once "core.config.php";
require_once "func.core.php";

/**
 * Description of Autoload
 * 
 * This autoloader class Loader have three methods inside that checks for classes
 * 
 * @author      Samet Tarim (prod3v3loper)
 * @copyright   (c) 2017, Samet Tarim
 * @link        https://www.tnado.com/
 * @package     Melabuai
 * @subpackage  autoloader
 * @since       1.0
 * @see         https://github.com/prod3v3loper/php-auto-autoloader
 */
class Loader extends LoaderHelper {

    /**
     * Directory for loop
     * @var type 
     */
    private $dir = array();

    /**
     * File for require class
     * @var type 
     */
    private $file = '';

    /**
     * Empty Array for all forced Files and folders
     * @var type 
     */
    private $list = array();

    /**
     * Found state
     * @var type 
     */
    protected $found = false;

    /**
     * Instance - interface, class, extends classes, abstract classes, trait
     * @var type 
     */
    protected $insatnce = '';

    /**
     * Namespace
     * @var type 
     */
    protected $namespace = '';

    /**
     * Constructor
     */
    public function __construct(array $dir) {

        $this->dir = $dir; // Root path dir/folder to force recrusive
        $this->action(); // Action

        if (!file_exists(MBT_CORE_AUTOLOAD_LOG_FOLDER)) {
            mkdir(MBT_CORE_AUTOLOAD_LOG_FOLDER, 0755);
        }
    }

    /**
     *  Action Handler
     */
    protected function action() {

        /**
         * We register our autoloader
         * @see http://php.net/manual/de/function.spl-autoload-register.php
         */
        if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
            if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
                spl_autoload_register(array($this, '__autoload'), true, true);
            } else {
                spl_autoload_register(array($this, '__autoload'));
            }
        } else {
            // Add alert
            echo 'Ohhh NO Autoload exists, you use a PHP version under 5.1.2';
        }

        /**
         * Control debug
         */
        if (MBT_DEBUG_DISPLAY_AUTOLOAD == true) {
            echo $this->logInfo();
        }
    }

    /**
     * This function is the Loader, the heart from autoloader
     * Here we search with 3 different methods, the used classes, interfaces or even abstract classes
     * 
     * @param type $name
     */
    protected function __autoload($name) {

        // Start Site load time needs core performance
        $timeA = start_time();

        $this->insatnce = $name;

        // Get namespace as folder path
        $classFilePath = str_replace(array("\\", "//"), "/", PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . $this->splitInsatnce(true));

        // Exists a folder with same path as the namespace and is dir
        if (file_exists($classFilePath) && is_dir($classFilePath) && !empty($this->splitInsatnce(true))) {

            ### This is the fastest way ###
//            $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'FAST';

            /**
             * If so, then we create the class file. 
             * That means we take the website root path and namespace as a folder path and the classname we put together with these.
             * 
             * ### Example ###
             * 
             * PATH:        /users/username/projects/sites/website/
             * NAMESPACE:   modal
             * CLASS:       AbstractEntity
             * 
             * Then the result example /users/username/projects/sites/website/modal/class.AbstractEntity.php
             */
            $classFile = $classFilePath . DIRECTORY_SEPARATOR . 'class.' . $this->splitInsatnce() . '.php';

            // Check if class file exists
            if (file_exists($classFile) && is_file($classFile)) {

                // Is file exists require
                require_once $classFile;
            }
            //..
            else {

                ### This method is slightly slower than the first, so 0.03 - 0.05 seconds ###
//                $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'MIDDLE';

                /**
                 * This function namspace as folder path and force only this path for class file.
                 * This means every file found in this folder is opened and searched for the classname. 
                 * As soon as the used class exists in a file, this is integrated.
                 * 
                 */
                // Otherwise we scan class filepath dir from namespace and get all files to require
                $this->list = $this->loopDirectory($classFilePath); // Get files
                $countedFiles = count($this->list['files']); // Count files
                for ($i = 0; $i < $countedFiles; $i++) { // Loop all files
                    $this->readFile($this->list['files'][$i]); // Check files for class
                }

                $this->loadWrite(); // Write load file
                $this->loadRead(); // Read and load
            }
        } else {

            ### This method is the slowest, but found class anything where ###
//            $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'SLOW';

            /**
             * This method is the slowest, because it scans all your folders. 
             * No matter how much files you have, all are opened, read and searched for the classname.
             * 
             * The complete path is the directory path, that you give the autoloader
             * DEFAULT: MBT_DOCUMENT_ROOT
             */
            // Get all Files from complete path
            $this->list = $this->loopDirectory();

            $countedFiles = count($this->list['files']); // Count files
            for ($i = 0; $i < $countedFiles; $i++) { // Loop all files
                $this->readFile($this->list['files'][$i]); // Check files for class
            }

            $this->loadWrite(); // Write load file
            $this->loadRead(); // Read and load
        }

        $endTimeA = end_time($timeA);

        $reuri = get_request_uri();
        $this->debugInfo[$reuri][$name] = $endTimeA;

        file_put_contents(MBT_CORE_AUTOLOAD_LOG_LOGS, serialize($this->debugInfo), LOCK_EX);
//        chmod(MBT_CORE_AUTOLOAD_LOG_LOGS, 0755);

        /**
         * Control debug
         */
        if (MBT_DEBUG_DISPLAY_AUTOLOAD_SEARCH == true) {
           echo $this->getDebug();
        }
    }

    /**
     * Loop all files and read it to found the instance class
     * 
     * @param type $filepath
     */
    protected function readFile($filepath) {

        $arr = array();
        $this->file = $this->getFile($filepath);
        if (false != $this->file) {
            foreach ($this->file as $lineNum => $line) {
                // Get actually namespace
//                $this->getNamespace($line, $arr);
                // Get actually class
                $this->getClass($filepath, $line, $arr, $lineNum);
                if ($lineNum > MBT_CORE_AUTOLOAD_READ_MAX_LINES || $this->found == true) {
                    $this->found = false;
                    break; // DEFAULT: 49 lines or by found = true, break the loop
                }
            }
        }
    }

    /**
     * Get class file
     * 
     * @return type
     */
    public function getFile($filepath) {

        $return = false;
        if (file_exists($filepath) && is_file($filepath)) {
            $return = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        return $return;
    }

    /**
     * Recursive all directorys in MBT_DOCUMENT_ROOT
     * 
     * @param type $dir
     * @param type $results
     * @return type
     */
    public function loopDirectory($dir = NULL, array &$results = array()) {

        if ($dir == NULL) {
            foreach ($this->dir as $direct) {
                $dir = $direct;
            }
        }

        $dir = str_replace("//", "/", $dir);

        if (file_exists($dir)) {
            $files = array_diff(scandir($dir, 1), array(".", ".."));
            foreach ($files as $value) {
                $path = $dir . DIRECTORY_SEPARATOR . $value; // If folder in folder
                $this->loopSort($path, $results);
            }
        }

        return $results;
    }

    /**
     * Sort files and folders
     * 
     * @param type $path
     */
    private function loopSort($path, array &$results = array()) {

        if (is_file($path)) {
            $results['files'][] = $path;
        }

        if (is_dir($path)) {
            $results['folders'][] = $path;
            $this->loopDirectory($path, $results);
        }
    }

}