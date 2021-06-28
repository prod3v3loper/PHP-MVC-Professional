<?php

namespace View;

/**
 * Description of FrontView
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class FrontView {

    protected static $context = array();

    /**
     * Display template
     * @param type $template
     */
    public static function display($template = "") {

        extract(self::$context);
        
        if ($template) {
            require_once $template;
        } else {
            require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/default.php';
        }
    }

    /**
     * 
     * @param type $key
     * @param type $value
     */
    public static function addContext($key, $value) {

        self::$context[$key] = $value;
    }

}
