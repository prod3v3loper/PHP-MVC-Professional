<?php

namespace Model;

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
abstract class ValidatorAbstract extends Model
{
    /**
     * CSRF - Cross Site Scripting Protect
     * 
     * @var string $csrf
     */
    protected $csrf = '';

    /**
     * This function set the CSRF token
     * 
     * @param bool $timer - Activate default timer
     * @param int $time - Manipulate default timer
     */
    public function setCsrf(bool $timer = false, int $time = (+ (0)))
    {
        mt_srand(microtime(true));
        if (isset($_SESSION) && !isset($_SESSION['csrf-token'])) {
            $_SESSION['csrf-token'] = mt_rand();
            if (true === $time) {
                $_SESSION['csrf-time'] = time() . $time;
            }
            $this->csrf = md5($_SESSION['csrf-token']);
        } else if (isset($_SESSION) && isset($_SESSION['csrf-token']) && !empty($_SESSION['csrf-token'])) {
            $this->csrf = $_SESSION['csrf-token'];
        }
    }

    /**
     * This function return the CSRF token back
     * 
     * @return string
     */
    public function getCsrf()
    {
        return md5($_SESSION['csrf-token']);
    }

    /**
     * This function clean the CSRF token
     */
    public function cleanCsrf()
    {
        if (isset($_SESSION['csrf-token'])) {
            unset($_SESSION['csrf-token']);
        }
        $this->csrf = '';
    }

    /**
     * CSRF Security token
     * 
     * @param string $token
     */
    public function validateCsrf($token)
    {
        if (false === isset($_SESSION['csrf-token']) || md5($_SESSION['csrf-token']) != $token) {
            $msg = '<b>' . __('Security problem') . ':</b>' . __('Invalid form token discovered') . ' - ' . __('Please try again');
            $this->addError($msg);
        }
    }

    /**
     * CSRF Security time
     * 
     * @param string $time
     */
    public function validateCsrfTime($time)
    {
        if (false === isset($_SESSION['csrf-time']) || isset($_SESSION['csrf-time']) && ($_SESSION['csrf-time'] + $this->minLifeTime) < time()) {
            $msg = '<b>' . __('Security problem') . ':</b>' . __('Time of security has expired') . ' - ' . __('Please try again');
            $this->addError($msg);
        }
    }

}