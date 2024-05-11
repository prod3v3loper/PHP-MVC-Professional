<?php

declare(strict_types=1);

namespace Aautoloder;

require_once "class.LoaderHelper.php";
require_once "core.config.php";
require_once "func.core.php";

/**
 * Description of Autoload
 * 
 * This autoloader class Loader have three methods inside that checks for classes
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
class Loader extends LoaderHelper
{

    /**
     * Directory for loop
     * 
     * @var array $dir
     */
    private $dir = [];

    /**
     * File for require class
     * 
     * @var array $file
     */
    private $file = [];

    /**
     * Empty Array for all forced Files and folders
     * 
     * @var array $list
     */
    private $list = [];

    /**
     * Found state
     * 
     * @var boolean $found
     */
    protected $found = false;

    /**
     * Instance - interface, class, extends classes, abstract classes, trait
     * 
     * @var string $instance
     */
    protected $instance = '';

    /**
     * Namespace
     * 
     * @var string $namespace
     */
    protected $namespace = '';

    public function __construct(array $dir)
    {
        $this->dir = $dir;
        $this->action();

        if (!file_exists(MBT_CORE_AUTOLOAD_LOG_FOLDER)) {
            mkdir(MBT_CORE_AUTOLOAD_LOG_FOLDER, 0755);
        }
    }

    /**
     * We register our autoloader
     * 
     * @see http://php.net/manual/de/function.spl-autoload-register.php
     */
    protected function action()
    {
        if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
            if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
                spl_autoload_register(array($this, '__autoload'), true, true);
            } else {
                spl_autoload_register(array($this, '__autoload'));
            }
        } else {
            echo 'Ohhh NO Autoload exists, you use a PHP version under 5.1.2';
        }

        if (MBT_DEBUG_DISPLAY_AUTOLOAD == true) {
            echo $this->logInfo();
        }
    }

    /**
     * This function is the Loader, the heart from autoloader
     * Here we search with 3 different methods, the used classes, interfaces or even abstract classes
     * 
     * @param string $name
     */
    protected function __autoload($name)
    {
        // Start Site load time needs core performance
        $timeA = start_time();

        $this->instance = $name;

        $classFilePath = '';
        if (!empty($this->splitInsatnce($this, true))) {
            // Get namespace as folder path
            $classFilePath = str_replace(array("\\", "//"), "/", PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . $this->splitInsatnce($this, true));
        }

        // Exists a folder with same path as the namespace and is dir
        if ($classFilePath && file_exists($classFilePath) && is_dir($classFilePath)) {

            ### This is the fastest way ###
            // $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'FAST';

            /**
             * METHOD I
             * 
             * If so, then we create the class file. 
             * That means we take the website root path and namespace as a folder path and the classname we put together with these.
             * 
             * ### Example ###
             * 
             * PROJECT PATH:    /project/site/mywebsite
             * NAMESPACE:       testclasses
             * CLASS:           first_class
             * 
             * Then the result example /project/site/mywebsite/testclasses/class.first_class.php
             */
            $classFile = '';
            if (!empty($this->splitInsatnce($this))) {
                $classFile = $classFilePath . DIRECTORY_SEPARATOR . 'class.' . $this->splitInsatnce($this) . '.php';
            }

            // Check if class file exists
            if ($classFile && file_exists($classFile) && is_file($classFile)) {
                require_once $classFile; // Is file exists load
            }
            //..
            else {

                ### This method is slightly slower than the first, so 0.03 - 0.05 seconds ###
                // $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'MIDDLE';

                /**
                 * METHOD II
                 * 
                 * This function namspace as folder path and force only this path for class file.
                 * This means every file found in this folder is opened and searched for the classname. 
                 * As soon as the used class exists in a file, this is integrated.
                 * 
                 * ### Example ###
                 * 
                 * This file name dont exists as example class.second_class.php we have class.second.php but the name of the class is second_class.
                 * Then the result example /project/site/mywebsite/testclasses/classes/class.second_class.php
                 */

                // Otherwise we scan class filepath dir from namespace (/project/site/mywebsite/testclasses/classes) and get all files to require
                if ($classFilePath && file_exists($classFilePath)) {

                    $this->list = $this->loopDirectory($classFilePath); // Get files

                    if (isset($this->list['files'])) {
                        $countedFiles = count($this->list['files']); // Count files
                        for ($i = 0; $i < $countedFiles; $i++) { // Loop all files
                            $this->readFile($this->list['files'][$i]); // Check files for class
                        }
                        $this->saveIndex(); // Write load file
                    }
                }

                $this->readIndex(); // Read and load
            }
        } else {

            ### This method is the slowest, but found class anything where ###
            // $this->debugInfo['MB_AUTOLOAD_INSTANCE'][] = 'SLOW';

            /**
             * METHOD III
             * 
             * This method is the slowest, because it scans all your folders. 
             * No matter how much files you have, all are opened, read and searched for the classname.
             * 
             * The complete path is the directory path, that you give the autoloader
             * DEFAULT: PROJECT_DOCUMENT_ROOT (Project root)
             */

            // Get all Files from complete path
            $this->list = $this->loopDirectory();

            if (isset($this->list['files'])) {
                $countedFiles = count($this->list['files']); // Count files
                for ($i = 0; $i < $countedFiles; $i++) { // Loop all files
                    $this->readFile($this->list['files'][$i]); // Check files for class
                }
                $this->saveIndex(); // Write load file
            }

            $this->readIndex(); // Read and load
        }

        $endTimeA = end_time($timeA);

        $reuri = get_request_uri();
        $this->debugInfo[$reuri][$name] = $endTimeA;

        file_put_contents(MBT_CORE_AUTOLOAD_LOG_LOGS, serialize($this->debugInfo), LOCK_EX);
        // chmod(MBT_CORE_AUTOLOAD_LOG_LOGS, 0755);

        if (MBT_DEBUG_DISPLAY_AUTOLOAD_SEARCH == true) {
            echo $this->getDebug();
        }
    }

    /**
     * Loop all files and read it to found the instance class
     * 
     * @param string $filepath
     */
    protected function readFile($filepath)
    {
        $arr = [];

        $this->file = $this->getFile($filepath);

        if (false !== $this->file && is_array($this->file)) {

            foreach ($this->file as $lineNum => $line) {

                // Get actually namespace
                // $this->getNamespace($line, $arr, $this);

                // Get actually class
                $this->getClass($filepath, $line, $arr, $lineNum, $this);

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
     * @return boolean|array
     */
    public function getFile($filepath)
    {
        $return = false;
        if (file_exists($filepath) && is_file($filepath)) {
            $return = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        return $return;
    }

    /**
     * Recursive all directorys in PROJECT_DOCUMENT_ROOT
     * 
     * @param string $dir
     * @param array $results
     * 
     * @return array
     */
    public function loopDirectory($dir = NULL, array &$results = [])
    {
        if ($dir == NULL) {
            $dir = $this->dir[0];
        }

        $ignoreDirs = [
            'autoload', 'vendor', '.git', 'node_modules', 'cache', 'logs', 'tests', 'build',
            'docs', 'documentation', 'assets', 'temp', 'bin', 'backup', 'config',
            'media', 'public', 'storage', 'resources', 'src', 'templates', 'views',
            'uploads', 'scripts', '.idea', 'dist', 'log', 'img'
        ];

        $ignoreFiles = [
            'composer.json', 'composer.lock', '.env',
            '.gitignore', '.htaccess', 'phpunit.xml',
            'README.md', 'LICENSE'
        ];

        $ignoreExtensions = [
            'md', 'json', 'yaml', 'yml', 'xml', 'ini', 'log', 'txt',
            'css', 'js', 'scss', 'less', 'html', 'htm', 'config'
        ];

        $dir = str_replace("//", "/", $dir);

        if (file_exists($dir) && is_dir($dir)) {

            $files = array_diff(scandir($dir, 1), array(".", ".."));

            foreach ($files as $file) {

                if ($file == '.' || $file == '..') continue;

                $fullPath = $dir . '/' . $file;
                $relativePath = str_replace(PROJECT_DOCUMENT_ROOT, '', $fullPath);
                $pathInfo = pathinfo($fullPath);

                $skip = false;

                foreach ($ignoreDirs as $ignoreDir) {
                    if (strpos($relativePath, '/' . $ignoreDir . '/') !== false) {
                        $skip = true;
                        break;
                    }
                }

                if (!$skip && in_array($file, $ignoreFiles)) {
                    $skip = true;
                }

                if (!$skip && isset($pathInfo['extension']) && in_array($pathInfo['extension'], $ignoreExtensions)) {
                    $skip = true;
                }

                if (!$skip) {

                    $path = $dir . DIRECTORY_SEPARATOR . $file; // If folder in folder
                    $this->loopSort($path, $results);
                }
            }
        }

        return $results;
    }

    /**
     * Sort files and folders
     * 
     * @param string $path
     */
    private function loopSort($path, array &$results = array())
    {
        if (is_file($path)) {
            $results['files'][] = $path;
        }

        if (is_dir($path)) {
            $results['folders'][] = $path;
            $this->loopDirectory($path, $results);
        }
    }
}
