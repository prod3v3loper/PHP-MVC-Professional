<?php

namespace Controller;

use View\FrontView as V;

/**
 * The Error Controller overwrite the PHP errorhandler and set this one for cache the errors and handle self
 *
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class ErrorController {
    
    const ERROR_CONTROLLER = "Controller\ErrorController";
    const ERROR_ACTION = "indexAction";

    /**
     * Call on non exists method
     * 
     * @param type $name
     * @param type $arguments
     */
//    public function __call($name, $arguments) {
//        // Redirect to index
//    }

    /**
     * Default 404
     */
    public function indexAction() {
        $this->error404Action();
    }

    /**
     * Error 404
     */
    public function error404Action() {

        // Set header
        header('HTTP/1.0 404 Not Found', true, 404);

        V::addContext('data', array(
            "templates" => array(
                "error"
//                "header",
//                "nav",
//                "home",
//                "footer"
            ),
            "meta-title" => "404",
            "robots" => "index, follow, noodp",
            "title" => "Not found",
            "description" => "404 Not found",
            "nav-active" => "home",
            "content" => "<h2>Not found</h2><p>This page was not found</p>",
        ));

        V::display();
        die();
    }

}
