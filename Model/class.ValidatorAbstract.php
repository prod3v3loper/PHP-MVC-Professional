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
     * 
     * @var integer $minLifeTime
     */
    protected $minLifeTime = 144;

    /**
     * This function set the CSRF token
     * 
     * @param boolean $timer - Activate default timer
     * @param integer $time - Manipulate default timer
     */
    public function setCsrf(bool $timer = false, int $time = (+ (0)))
    {
        mt_srand(floor(microtime(true)));
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
}
