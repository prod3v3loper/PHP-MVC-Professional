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
class File
{
    /**
     * Write function 
     *
     * @param string $filename
     * @param string $content
     */
    public function write(string $content = '', string $filename = '')
    {
        $filename = $filename != '' ? $filename : 'file.log';

        if (!$handle = fopen($filename, "a")) {
            trigger_error("Can not open file $filename");
        }

        if (fwrite($handle, $content) === FALSE) {
            trigger_error("Can not write in file $filename");
        }

        fclose($handle);

        chmod($filename, 0600);
    }
}
