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

    /**
     * @var array $context
     */
    protected static $context = [];

    /**
     * Display template
     * 
     * @param string $template
     */
    public static function display(string $template = '')
    {
        extract(self::$context);

        if ($template) {
            require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/' . $template;
        } else {
            require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/index.php';
        }
    }

    /**
     * Add context to get in template
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function addContext(string $key = '', $value)
    {
        self::$context[$key] = $value;
    }
}
