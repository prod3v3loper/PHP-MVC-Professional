<?php

namespace Controller;

use View\FrontView as V,
    Modal\user\User as U;

/**
 * Description of UserController
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class UserController extends AbstractController
{

    /**
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param type array $params
     */
    public function loginAction($params = "")
    {
        // Create login template
        // Check the post here from form and check with user repo
        $USER = new U;

        // If login form send
        if (isset($_POST["login"])) {
            // Validate all fields in validator
            $USER->validateByArray($_POST);
            // Is valid ?
            if ($USER->isValid()) {
                // Set all data to User Object
                $USER->setByArray($_POST);
            }
        }

        V::addContext('data', array(
            "templates" => array(
                //                "header",
                //                "nav",
                "login",
                //                "home",
                //                "footer"
            ),
            "meta-title" => "Login",
            "robots" => "index, follow, noodp",
            "title" => "User Login",
            "description" => "Free login and use",
            "nav-active" => "home",
            "content" => "<h2>Content</h2><p>Content to template.</p>",
        ));

        V::display();
    }

    // Add more methods for register, password forgot etc.

}
