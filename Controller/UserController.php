<?php

namespace Controller;

use View\FrontView as V,
    Model\user\User as U,
    core\classes\mail\Mailer as SM;

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
     * @param array $params
     */
    public function registerAction(array $params = [])
    {
        $USER = new U;
        $smailer = new SM();

        $USER->setCsrf();

        // If register form send
        if (isset($_POST["register"])) {
            // Validate all fields in validator
            $USER->validateByArray($_POST);
            // Is valid ?
            if ($USER->isValid()) {
                // Set all data to User modal
                $USER->setByArray($_POST);
                if ($USER->findByAttribute(array('email'), array($USER->getEmail()), 'email')) {
                    $USER->addError('YOU are already registered!');
                } else {
                    // Save user in db
                    if ($USER->save()) {
                        $args = [
                            'to' => $USER->getEmail(),
                            'subject' => 'Register',
                            'body' => 'Please confirm your registriation'
                        ];
                        if ($smailer->sendMail($args)) {
                            $USER->addSuccess('YOU are registered, check your email for complete!');
                            $USER->cleanCsrf();
                        }
                    } else {
                        $USER->addError('YOU are NOT registered, SORRY!');
                    }
                }
            }
        }

        V::addContext('data', array(
            'templates' => array(
                "header",
                "nav",
                'form/register',
                "footer"
            ),
            'robots' => 'noindex, nofollow, noodp',
            'title' => 'User Register',
            'description' => 'Form to register user',
            'nav-active' => 'register',
            'content' => 'Form to register user',
            'csrf' => $USER->getCsrf(),
            'errors' => $USER->getErrors()
        ));

        V::display();
    }

    /**
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param array $params
     */
    public function loginAction(array $params = [])
    {
        $USER = new U;

        // First time add admin
        //        $USER->setFirstname('Firstname');
        //        $USER->setLastname('Lastname');
        //        $USER->setName('Username');
        //        $USER->setEmail('email@tester.test');
        //        $USER->setPassword('chango123#');
        //        $USER->hashPassword();
        //        $USER->setMeta([]);
        //        $USER->setRole(1);
        //        $USER->setAccept(1);
        //        $USER->saveObject();
        //        die();

        $USER->setCsrf();

        if (isset($_POST["login"])) {
            $USER->validateByArray($_POST);
            if ($USER->isValid()) {
                $USER->setByArray($_POST);
                if (!$USER->login()) {
                    $USER->addError('YOU cant logged in, SORRY!');
                } else {
                    $USER->addSuccess('YOU are logged in, WELCOME Back!');
                    $USER->cleanCsrf();
                    header("Location: " . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'admin/dash/', true, 302);
                }
            }
        }

        V::addContext('data', array(
            'templates' => array(
                "header",
                "nav",
                'form/login',
                "footer"
            ),
            'robots' => 'noindex, nofollow, noodp',
            'title' => 'User Login',
            'description' => 'Form to login user',
            'nav-active' => 'login',
            'content' => 'Form to login user',
            'csrf' => $USER->getCsrf(),
            'errors' => $USER->getErrors(),
        ));

        V::display();
    }

    /**
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param array $params
     */
    public function passwordAction(array $params = [])
    {
        $USER = new U;
        $USER->setCsrf();

        // If login form send
        if (isset($_POST["pass"])) {
            // Validate all fields in validator
            $USER->validateByArray($_POST);
            // Is valid ?
            if ($USER->isValid()) {
                // Set all data to User modal
                $USER->setByArray($_POST);
                if ($USER->findByAttribute(array('email'), array($USER->getEmail()), 'email')) {
                    $USER->addSuccess('YOUR account was found!');
                    $USER->cleanCsrf();
                    // @todo Mail send with password reset
                } else {
                    $USER->addError('YOU account was NOT found, SORRY!');
                }
            }
        }

        V::addContext('data', array(
            'templates' => array(
                "header",
                "nav",
                'form/password',
                "footer"
            ),
            'robots' => 'noindex, nofollow, noodp',
            'title' => 'Password forget',
            'description' => 'Reset password with email',
            'nav-active' => 'password',
            'content' => 'Reset password with email',
            'csrf' => $USER->getCsrf(),
            'errors' => $USER->getErrors(),
        ));

        V::display();
    }

    // Add more methods for register, password forgot etc.
}
