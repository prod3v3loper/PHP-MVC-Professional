<?php

namespace Controller;

use View\FrontView as V,
    Model\user\User;

/**
 * Description of AdminController
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class AdminController extends AbstractController
{
    /**
     *
     * @var object $user
     */
    private $user = null;

    /**
     * 
     */
    public function __construct()
    {
        $this->user = new User();
        if (!$this->user->loggedIn()) {
            header('Location: ' . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/login/', true, 302);
        }
        
        $this->user = User::findById((int) $_SESSION['user-id']);
    }

    /**
     * This is the first action called on default
     * The parameter is filled in the front controller and is automatically given to every action called
     * 
     * @param array $params
     */
    public function dashAction(array $params = [])
    {
        V::addContext('data', array(
            'templates' => array(
                'header',
                'nav',
                'admin/dashboard',
                'footer'
            ),
            'robots' => 'noindex, nofollow, noodp',
            'title' => 'Dashboard',
            'description' => 'Admin Dashboard',
            'nav-active' => 'dash',
            'content' => '<h2>Admin</h2><p><b>Welcome</b> ' . $this->user->getName() . ',<br><i>This is your dashboard</i>. Create more sites for admin and build your site.</p>',
            'image' => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . "core/img/home.jpg",
            'user' => $this->user
        ));

        V::display();
    }

    /**
     * 
     * @param array $params
     */
    public function logoutAction(array $params = [])
    {
        $user = new User();
        $user->logout();
    }

}