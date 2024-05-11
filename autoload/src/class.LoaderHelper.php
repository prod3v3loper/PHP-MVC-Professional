<?php

namespace Aautoloder;

/**
 * Description of Autoload
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2024, prod3v3loper
 * @link        https://www.prod3v3loper.com/
 * @package     Melabuai
 * @subpackage  Autoloader
 * @version     1.1
 * @since       1.1
 * @see         https://github.com/prod3v3loper/php-auto-autoloader
 */
class LoaderHelper
{
    /**
     * 
     * @var array $loader
     */
    protected $loader = [];

    /**
     * 
     * @var array $loadHandler 
     */
    protected $loadHandler = [];

    /**
     * Debug information
     * 
     * @var array $debugInfo
     */
    protected $debugInfo = [];

    protected function updateIndex()
    {
        $newIndex = [];
        foreach ($this->loader as $classname => $filepath) {
            if (file_exists($filepath)) {
                $newIndex[$classname] = $filepath;
            }
        }
        $this->loader = $newIndex;
        $this->saveIndex();
    }

    /**
     * This function is for the index, a file is a class file and not in the array
     * 
     * @param string $classname
     * @param string $filepath
     */
    protected function loadIndex($classname, $filepath)
    {
        $classname = (string) trim(mb_substr($classname, 0, strpos($classname, ' ')));
        if ($classname and !in_array($classname, array_keys($this->loader))) {
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
    protected function saveIndex()
    {
        if (MBT_CORE_AUTOLOAD_INDEX) {
            if (!file_put_contents(MBT_CORE_AUTOLOAD_LOG_FILE, serialize($this->loader), LOCK_EX)) {
                trigger_error('Can\'t write the autoload index file ' . MBT_CORE_AUTOLOAD_LOG_FILE, E_USER_WARNING);
            } else {
                // chmod(MBT_CORE_AUTOLOAD_LOG_FILE, 0755);
            }
        }
    }

    /**
     * This function read the load files and load all needed classes, that not found with PSR-4
     * 
     * @param boolean $mod
     */
    protected function readIndex($mod = false)
    {
        // $this->updateIndex();

        /**
         *  @see http://php.net/manual/de/function.file-exists.php
         */
        if (file_exists(MBT_CORE_AUTOLOAD_LOG_FILE)) {

            /**
             * @see http://php.net/manual/de/function.unserialize.php
             * @see http://php.net/manual/de/function.file-get-contents.php
             */
            $this->loadHandler = unserialize(file_get_contents(MBT_CORE_AUTOLOAD_LOG_FILE));
            if (is_array($this->loadHandler)) {
                foreach ($this->loadHandler as $class => $classFile) {
                    $info = pathinfo($classFile);
                    if (file_exists($classFile) && $info["extension"] == "php") {
                        require_once $classFile;
                    }
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
     * @param integer $line
     * @param array $arr
     * 
     * @return string
     */
    protected function getNamespace($line, $arr, $obj = NULL)
    {
        // Get actually namespace
        $namespaceRegEx = '/((namespace)+\s*(' . preg_quote($this->splitInsatnce($obj, true)) . ');)/';
        if (preg_match_all($namespaceRegEx, $line, $arr)) {
            // Debug information
            $this->debugInfo[] = '<b>Namespace:</b> <span style="color:blue;">' . $arr[0][0] . '</span>';
        }
    }

    /**
     * This function get the actually needed class and class filepath
     * And check the extension so that the wrong file is not loaded
     * 
     * @todo Check the next line for {
     * 
     * @param string $filepath
     * @param integer $line
     * @param array $arr
     * @param integer $lineNum
     */
    protected function getClass($filepath, $line, $arr, $lineNum, $obj = NULL)
    {
        // Get actually class
        $classRegEx = '/((interface|abstract\s+class|class|trait)+\s+(' . preg_quote($this->splitInsatnce($obj)) . ')(.*)\{?)/';

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
                $obj->found = true;

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
     * @param boolean $namespaceORclass
     * 
     * @return string
     */
    protected function splitInsatnce($obj = NULL, $namespaceORclass = false)
    {
        if ($obj->instance) {
            $obj->namespace = explode('\\', $obj->instance);
            $getLastForName = count($obj->namespace) - 1;
            $classname = $obj->namespace[$getLastForName];
            unset($obj->namespace[$getLastForName]);
            if ($namespaceORclass == true) {
                $return = implode('\\', $obj->namespace);
            } else {
                $return = $classname;
            }

            return $return;
        }
    }

    /**
     * This function gives information for loadtime e.g.
     * 
     * @return string
     */
    public function logInfo()
    {
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
     * @return string
     */
    public function getDebug()
    {
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
