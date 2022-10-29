<?php

namespace Controller;

use View\FrontView as V,
    Model\contact\Contact as C,
    core\classes\mail\Mailer as SM,
    core\classes\secure\HoneyPot;

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
     * You can get content from db
     * 
     * Start Site
     * 
     * @param string $params
     */
    public function indexAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "home",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "Start",
            "description" => "Free SEO online tools from tnado take you to the top. Try your site today to optimize on onpage as offpage and much more.",
            "nav-active" => "home",
            "content" => "<h2>Welcome to the Melabuai MVC Homepage</h2><p>This MVC is an <b>Professional</b> Model View Controller</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));
        
        V::display();
    }

    /**
     * About page
     * 
     * @param string $params
     */
    public function aboutAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "about",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "About us",
            "description" => "Our story about SEO programming optimization with background and all that belongs to it can be found here.",
            "nav-active" => "about",
            "content" => "<h2>About</h2><p>Whitelabel Framwork easy and understandable.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * Blog page
     * 
     * @param string $params
     */
    public function blogAction(array $params = [])
    {
        V::addContext('data', array(
            // On templates you can change all if you want to style another
            "templates" => array(
                "header", // create new header header-blog and in the core/tpl folder header-blog.tpl.php
                "nav", // create new nav nav-blog
                "blog",
                "footer" // create new footer-blog
            ),
            "robots" => "index, follow, noodp",
            "title" => "Blog",
            "description" => "We provide support and expect support, so if there is any support please contact us or we will support you with our know how.",
            "nav-active" => "blog",
            "content" => "<h2>Blog</h2><p>We provide support and expect support. So if there is any support please contact us or we will support you with our know how.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * Contact page with form
     * 
     * @param string $params
     */
    public function contactAction(array $params = [])
    {
        $smailer = new SM();

        // EXAMPLE USE OF A MODAL
        /**
         * Contact model instance
         * Call from class.ContactModel.php
         */
        $contact = new C();
        $contact->setCsrf(); // Create csrf token for form in template
        // If contact form send
        if (isset($_POST["contact"])) {
            // Validate all fields in validator
            $contact->validateByArray($_POST);
            // Is valid ?
            if ($contact->isValid()) {
                // Set all data to User modal
                $contact->setByArray($_POST);
                /**
                 * Save user in db
                 * Call from class.UserModel.php
                 */
                if ($contact->saveObject()) {
                    if ($smailer->sendMail($contact->getEmail(), 'Thanks for contact', 'We have received your contact message')) {
                        $contact->addSuccess('Mail send thanks for contact us');
                        $contact->cleanCsrf(); // Clean csrf token on success
                    } else {
                        $contact->addError('Mail not send, please try again');
                    }
                }
            }
        }

        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "contact",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "Contact us",
            "description" => "",
            "nav-active" => "contact",
            "content" => "<h2>Contact</h2><p>We love to build connection you too ? Then feel ever free and contact us.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg",
            'csrf' => $contact->getCsrf(), // Use in form token
            'success' => $contact->getSuccess(), // All success
            'errors' => $contact->getErrors() // All errors
        ));

        V::display();
    }

    /**
     * Support page
     * 
     * @param string $params
     */
    public function supportAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "support",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "Support",
            "description" => "We provide support and expect support, so if there is any support please contact us or we will support you with our know how.",
            "nav-active" => "support",
            "content" => "<h2>Support</h2><p>We provide support and expect support. So if there is any support please contact us or we will support you with our know how.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * Imprint page
     * 
     * @param string $params
     */
    public function imprintAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "imprint",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "Imprint",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "nav-active" => "imprint",
            "content" => "<h2>Imprint</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * Privacy Page
     * 
     * @param string $params
     */
    public function privacyAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "privacy",
                "footer"
            ),
            "robots" => "index, follow, noodp",
            "title" => "Privacy",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "nav-active" => "privacy",
            "content" => "<h2>Privacy</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>",
            "image" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg"
        ));

        V::display();
    }

    /**
     * If someone calls the url /login then we log them, because we don't have an login under this controller
     * 
     * Congrulations the first honeypot !!!
     * 
     * @param string $params
     */
    public function loginAction(array $params = [])
    {
        HoneyPot::logging();

        V::addContext('data', array(
            "templates" => array(
                "error"
            ),
            "title" => "Error",
        ));

        V::display();
        die();
    }

    // Add more honeypots...
}