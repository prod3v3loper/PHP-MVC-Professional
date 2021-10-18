<?php

namespace Controller;

use View\FrontView as V;

/**
 * Description of indexController
 * 
 * You can create multiple controllers e.g. for login, admin pages etc.
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class IndexController extends AbstractController
{

    /**
     * This is the first action called on default
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param type $params
     */
    public function indexAction($params = "")
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "home",
                "footer"
            ),
            "meta-title" => "Online, FREE and unlimited usage",
            "robots" => "index, follow, noodp",
            "title" => "SEO Tools Online for FREE and unlimited usage",
            "description" => "Free SEO online tools from tnado take you to the top. Try your site today to optimize on onpage as offpage and much more.",
            "nav-active" => "home",
            "content" => "<h2>Search Engine Optimization</h2><p>Free Search Engine Optimization tools from tnado take you to the top. Try your site today to optimize on onpage as offpage and much more. With our tools you can check everything without limits.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * 
     */
    public function aboutAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "about",
                "footer"
            ),
            "meta-title" => "About",
            "robots" => "index, follow, noodp",
            "title" => "About us",
            "description" => "Our story about SEO programming optimization with background and all that belongs to it can be found here.",
            "nav-active" => "about",
            "content" => "<h2>About</h2><p>TNADO is specializes in SEO & AMP. Our story about SEO programming optimization with background and all that belongs to it can be found here.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function blogAction()
    {

        V::addContext('data', array(
            // On templates you can change all if you want to style another
            "templates" => array(
                "header", // create new header header-blog and in the core/tpl folder header-blog.tpl.php
                "nav", // create new nav nav-blog
                "blog",
                "footer" // create new footer-blog
            ),
            "meta-title" => "Support",
            "robots" => "index, follow, noodp",
            "title" => "Support",
            "description" => "We provide support and expect support, so if there is any support please contact us or we will support you with our know how.",
            "nav-active" => "support",
            "content" => "<h2>Support</h2><p>We provide support and expect support. So if there is any support please contact us or we will support you with our know how.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function supportAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "support",
                "footer"
            ),
            "meta-title" => "Support",
            "robots" => "index, follow, noodp",
            "title" => "Support",
            "description" => "We provide support and expect support, so if there is any support please contact us or we will support you with our know how.",
            "nav-active" => "support",
            "content" => "<h2>Support</h2><p>We provide support and expect support. So if there is any support please contact us or we will support you with our know how.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function contactAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "contact",
                "footer"
            ),
            "meta-title" => "Contact",
            "robots" => "index, follow, noodp",
            "title" => "Contact us",
            "description" => "",
            "nav-active" => "contact",
            "content" => "<h2>Contact</h2><p>We love to build connection you too ? Then feel ever free and contact us.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function advertisingAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "advertising",
                "footer"
            ),
            "meta-title" => "Advertising",
            "robots" => "index, follow, noodp",
            "title" => "Advertising",
            "description" => "",
            "nav-active" => "advertising",
            "content" => "<h2>Advertising</h2><p>We can place your Company on the fields.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function imprintAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "imprint",
                "footer"
            ),
            "title" => "Imprint",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function privacyAction()
    {

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "privacy",
                "footer"
            ),
            "title" => "Privacy",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    public function errorAction()
    {

        header("HTTP/1.0 404 Not Found");

        V::addContext('data', array(
            "templates" => array(
                "error",
            ),
            "meta-title" => "404",
            "title" => "404 Page not found",
            "description" => "This is the page that appears and does not appear if a page on our server does not exist, but it can lead you back to a working page."
        ));

        V::display();
    }
}
