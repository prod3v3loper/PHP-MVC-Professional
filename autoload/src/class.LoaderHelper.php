<?php

namespace Aautoloder;

/**
 * Description of Autoload
 * 
 * @author      Samet Tarim (prod3v3loper)
 * @copyright   (c) 2017, Samet Tarim
 * @link        https://www.tnado.com/
 * @package     Melabuai
 * @subpackage  autoloader
 * @since       1.0
 * @see         https://github.com/prod3v3loper/php-auto-autoloader
 */
class LoaderHelper {

    /**
     * 
     * @var type 
     */
    protected $loader = array();

    /**
     * 
     * @var type 
     */
    protected $loadHandler = '';

    /**
     * Debug information
     * 
     * @var type 
     */
    protected $debugInfo = array();

    /**
     * This function is for the index, a file is a class file and not in the array
     * 
     * @param type $classname
     * @param type $filepath
     */
    protected function loadIndex($classname, $filepath) {

        $classname = (string) trim(mb_substr($classname, 0, strpos($classname, ' ')));
        if ($classname AND ! in_array($classname, array_keys($this->loader))) {
            $this->loader[$classname] = $filepath;
        }
    }

    /**
     * This function write the load files as index for searched and founded classes.
     * Needed for full search and fast found
     * 
     * Serilize array and save as string in file
     * This file loads all classes that found and needed
     * 
     * @see http://php.net/manual/de/function.serialize.php
     * @see http://php.net/manual/de/function.file-put-contents.php
     */
    protected function loadWrite() {

        if (MBT_CORE_AUTOLOAD_INDEX) {
            if (!file_put_contents(MBT_CORE_AUTOLOAD_LOG_FILE, serialize($this->loader), LOCK_EX)) {
                trigger_error('Can\'t write the autoload loader file ' . MBT_CORE_AUTOLOAD_LOG_FILE, E_USER_WARNING);
            } else {
//                chmod(MBT_CORE_AUTOLOAD_LOG_FILE, 0755);
            }
        }
    }

    /**
     * This function read the load files and load all needed classes, that not found with PSR-0
     * 
     * @return boolean
     */
    protected function loadRead($mod = false) {

        /**
         *  @see http://php.net/manual/de/function.file-exists.php
         */
        if (file_exists(MBT_CORE_AUTOLOAD_LOG_FILE)) {

            /**
             * @see http://php.net/manual/de/function.unserialize.php
             * @see http://php.net/manual/de/function.file-get-contents.php
             */
            $this->loadHandler = unserialize(file_get_contents(MBT_CORE_AUTOLOAD_LOG_FILE));
            foreach ($this->loadHandler as $class => $classFile) {
                $info = pathinfo($classFile);
                if (file_exists($classFile) && $info["extension"] == "php") {
                    require_once $classFile;
                }
            }
        }
        //..
        else {

            trigger_error('Can\'t found the autoload loader file ' . MBT_CORE_AUTOLOAD_LOG_FILE, E_USER_WARNING);
        }
    }

    /**
     * This function get the actually namespace
     * 
     * @param type $line
     * @param type $arr
     * @return string
     */
    protected function getNamespace($line, $arr) {

        // Get actually namespace
        $namespaceRegEx = '/((namespace)+\s*(' . preg_quote($this->splitInsatnce(true)) . ');)/';
        if (preg_match_all($namespaceRegEx, $line, $arr)) {
            // Debug information
            $this->debugInfo[] = '<b>Namespace:</b> <span style="color:blue;">' . $arr[0][0] . '</span>';
        }
    }

    /**
     * This function get the actually needed class and class filepath
     * Check extentions for not load wrong files
     * 
     * @todo Check the next line for {
     * @param type $filepath
     * @param type $line
     * @param type $arr
     * @param type $lineNum
     */
    protected function getClass($filepath, $line, $arr, $lineNum) {

        // Get actually class
        $classRegEx = '/((interface|abstract\s+class|class|trait)+\s+(' . preg_quote($this->splitInsatnce()) . ')(.*)\{?)/';
        if (preg_match_all($classRegEx, trim($line), $arr)) {
            // Founded class
            $class = $arr[3][0];
            // Get pathinfo
            $info = pathinfo($filepath);
            if (!isset($this->loader[$class]) && file_exists($filepath) && $info["extension"] == "php") {
                // Hold loader class and filepath
                $this->loader[$class] = $filepath;
                // $this->loadIndex($class, $filepath);
                // Found true for break
                $this->found = true;
                // Debug information
                $this->debugInfo[] = '<b>NEEDED CLASS</b><br>';
                $this->debugInfo[] = '<b>Class:</b> <span style="color:lightblue;">' . trim($line) . '</span><br>';
                $this->debugInfo[] = '<b>File:</b> ' . $filepath . '<br>';
                $this->debugInfo[] = '<b>Line:</b> <span style="color:orange;">' . $lineNum . '</span><br>';
            }
        }
    }

    /**
     * This function split the namespace and class, you can get the only namespace or only classname
     * 
     * @uses splitInsatnce(false) For classname
     * @uses splitInsatnce(true) For namespace
     * 
     * @param type $namespaceORclass
     * @return type String
     */
    protected function splitInsatnce($namespaceORclass = false) {

        if ($this->insatnce) {

            $this->namespace = explode('\\', $this->insatnce);
            $getLastForName = count($this->namespace) - 1;
            $classname = $this->namespace[$getLastForName];
            unset($this->namespace[$getLastForName]);
            if ($namespaceORclass == true) {
                $return = implode('\\', $this->namespace);
            } else {
                $return = $classname;
            }

            return $return;
        }
    }

    /**
     * This function gives information for loadtime e.g.
     * 
     * @return type String
     */
    public function logInfo() {

        $output = '';
        $output .= '<table border="1">';
        $output .= '<tr>';
        $output .= '<th>Namespace as Foldername (Instance) </th>';
        $output .= '<th>Load Time</th>';
        $output .= '</tr>';
        if (file_exists(MBT_CORE_AUTOLOAD_LOG_LOGS)) {
            $debugInfo = unserialize(file_get_contents(MBT_CORE_AUTOLOAD_LOG_LOGS));
            if ($debugInfo) {
                $counter = 0;
                foreach ($debugInfo as $key => $value) {
                    // $output .= '</tr><tr>';
                    // $output .= '<td colspan="2" style="text-align:center;"><strong>' . $key . ' (' . count($value) . ')</strong></td>';
                    $i = 0;
                    if (is_array($value)) {
                        foreach ($value as $val => $v) {
                            $output .= '</tr><tr>';
                            $output .= '<td>' . $val . '</td>';
                            $output .= '<td>' . ($v > 0.100 ? '<span style="color:red">' . $v . ' sec.</span>' : '<span style="color:green">' . $v . ' sec.</span>') . '</td>';
                            $i++;
                        }
                    }
                    $counter++;
                }
            }
        }
        $output .= '</table>';

        return $output;
    }

    /**
     * This function gives debug information
     * 
     * @return type String
     */
    public function getDebug() {

        $output = '';
        $output .= '<table>';
        $output .= '<tr>';
        $output .= '<th>Debugging</th>';
        $output .= '</tr>';
        if ($this->debugInfo) {
            $i = 0;
            foreach ($this->debugInfo as $key => $value) {
                if ($i % 4 == 0) {
                    $output .= '</tr><tr>';
                }
                if (is_array($value)) {
                    $output .= '<td><strong> ' . count($value) . '</strong></td>';
                } else {
                    $output .= '<td><strong> ' . $value . '</strong></td>';
                }
            }
            $i++;
        }
        $output .= '</table>';

        return $output;
    }

}
