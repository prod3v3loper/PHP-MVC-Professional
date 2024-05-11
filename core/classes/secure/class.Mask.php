<?php

namespace core\classes\secure;

/**
 * Description of Security Mask
 *
 * @author      prod3v3loper
 * @copyright   (c) 2022, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Mask
{
    /**
     * Before you write something to a file or save it in the database, you have to make data harmless. 
     * Use this function to neutralize all incoming data e.g. rich text editor
     * 
     * @see https://www.php.net/manual/de/function.htmlentities.php
     * 
     * @param string $data - Your string to encode for security
     * @param bool $strip - (true|false) To use the allowed tags set to true
     * @param string $allowedTags - Set your HTML tags you want to allow
     * 
     * @return string
     */
    public static function encode(string $data = '', bool $strip = false, string $allowedTags = '')
    {
        if ($data != '') {
            $trimed = trim($data); // Remove whitespaces before and after
            // Self cleanup too ?
            if ($strip === true) {
                $trimed = strip_tags($trimed, ($allowedTags != '' ? $allowedTags : '')); // Remove tags
                $trimed = preg_replace('/ {2,}/', ' ', $trimed); // Remove multiple spaces
            }
            $data = htmlentities($trimed, ENT_QUOTES, "UTF-8");
        }

        return $data;
    }

    /**
     * If you want to return encoded and saved data to its original state, use this feature, but use it with caution and care. 
     * If you spend the data in their original state and the content contains malicious code this is executed.
     * 
     * @see https://www.php.net/manual/de/function.html-entity-decode.php
     * 
     * @param string $data - Your string to decode
     * 
     * @return string
     */
    public static function decode(string $data = '')
    {
        if ($data != NULL) {
            $data = html_entity_decode($data, ENT_QUOTES, "UTF-8");
        }

        return $data;
    }
}
