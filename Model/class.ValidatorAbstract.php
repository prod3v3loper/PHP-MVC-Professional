<?php

namespace Modal;

/**
 * Description of Validator
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class ValidatorAbstract extends Modal
{

    /**
     * CSRF - Cross Site Scripting Protect
     * @var type 
     */
    protected $csrf = '';

    /**
     * This function set the CSRF token
     * @param type
     */
    public function setCsrfToken($timer = false, $time = (+ (0)))
    {

        mt_srand(microtime(true));

        if (isset($_SESSION) && !isset($_SESSION['csrf-token'])) {

            $_SESSION['csrf-token'] = mt_rand();

            if (true === $timer) {
                $_SESSION['csrf-time'] = time() . $time;
            }

            $this->csrf = md5($_SESSION['csrf-token']);
        }
        //..
        else if (isset($_SESSION) && isset($_SESSION['csrf-token']) && !empty($_SESSION['csrf-token'])) {

            $this->csrf = $_SESSION['csrf-token'];
        }
    }

    /**
     * This function return the CSRF token back
     * @param type
     */
    public function getCsrfToken()
    {

        return md5($_SESSION['csrf-token']);
    }

    /**
     * This function clean the CSRF token
     * @param type
     */
    public function cleanCsrfToken()
    {

        if (isset($_SESSION['csrf-token'])) {
            unset($_SESSION['csrf-token']);
        }

        $this->csrf = '';
    }
}
