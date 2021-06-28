<?php

namespace Controller;

use View\FrontView as V;

/**
 * Description of AdminController
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2019, prod3v3loper
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class AdminController extends AbstractController {

    /**
     * This is the first action called on default
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param type $params
     */
    public function indexAction($params = "") {
        
        // Check if admin logged in && is admin and do what you want

        V::addContext('data', array(
            "templates" => array(
//                "header",
//                "nav",
                "admin/dashboard",
//                "home",
//                "footer"
            ),
            "meta-title" => "Login",
            "robots" => "index, follow, noodp",
            "title" => "User Login",
            "description" => "Free login and use",
            "nav-active" => "home",
            "content" => "<h2>Content</h2><p>Content to template.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

}
