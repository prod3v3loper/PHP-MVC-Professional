<?php

namespace Controller;

use View\FrontView as V,
    core\classes\server\Server as S,
    core\classes\file\File as F;

/**
 * The Error Controller overwrite the PHP errorhandler and set this one for cache the errors and handle self
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class ErrorController
{

    /**
     * Default
     */
    public function indexAction()
    {
        $this->error404Action();
    }

    /**
     * Error 404
     */
    public function error404Action()
    {
        header('HTTP/1.0 404 Not Found', true, 404);

        V::addContext('data', array(
            "templates" => array(
                "error"
            ),
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