<?php

namespace core\classes\lang;

/**
 * Description of Language
 *
 * This is the language system, handle all cache actions in control of frontcontroller
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2022, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Lang
{
    /**
     * 
     * @param string $lang
     */
    public static function setLang(string $lang = '')
    {
        if (!isset($_SESSION['language'])) {
            // Create session language
            $_SESSION['language'] = $lang ? $lang : 'en';
        } else {
            // Edit session language
            $_SESSION['language'] = $lang ? $lang : 'en';
        }
    }

    /**
     * 
     * @return string
     */
    public static function getLang()
    {
        return isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
    }
}
