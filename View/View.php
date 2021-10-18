<?php

namespace View;

/**
 * Description of FrontView
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class FrontView
{

    protected static $context = array();

    /**
     * Display template
     * 
     * @param String $template
     */
    public static function display($template = "")
    {
        extract(self::$context);

        if ($template) {
            require_once $template;
        } else {
            require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/default.php';
        }
    }

    /**
     * Add context to get in template
     * 
     * @param String $key
     * @param String $value
     */
    public static function addContext($key, $value)
    {
        self::$context[$key] = $value;
    }
}
