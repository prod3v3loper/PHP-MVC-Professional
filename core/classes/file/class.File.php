<?php

namespace core\classes\file;

/**
 * Description of File
 * 
 * The File write the data in log file
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class File {

    /**
     * Write function 
     *
     * @param string $filename
     * @param string $content
     */
    public function write(string $content = '', string $filename = '') {

        $filename = $filename != '' ? $filename : 'file.log';

        if (!$handle = fopen($filename, "a")) {
            // print "Can not open file $filename";
            exit;
        }
        
        if (fwrite($handle, $content) === FALSE) {
            // print "Can not write in file $filename";
            exit;
        }
        
        fclose($handle);

        // Set file rights and only owner can read and edit others not
        chmod($filename, 0600);
    }

}
