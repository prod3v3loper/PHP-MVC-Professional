<?php

namespace core\classes\http;

/**
 * Description of Filter
 * 
 * All data that comes in must be checked as well as possible and these methods will help you as much as possible.
 * The system inherently includes security measures when saving to the database or to a file. 
 * However, if own code is added in one place, all security functions should be used, unless you use the same classes and functions that already exist.
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class Filter
{
    // VAR VALIDATE & SANITIZE

    /**
     * 
     * @param string $email - The email address to validate
     * 
     * @return string
     */
    public static function validateEmail($email)
    {
        return (string) self::applyFilter($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * 
     * @param string $email - The email address to sanitize
     * 
     * @return string
     */
    public static function sanitizeEmail($email)
    {
        return (string) self::applyFilter($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * 
     * @param string $url - The url to validate
     * 
     * @return string
     */
    public static function validateURI($uri)
    {
        return (string) self::applyFilter($uri, FILTER_VALIDATE_URL);
    }

    /**
     * 
     * @param string $url - The url to sanitize
     * 
     * @return string
     */
    public static function sanitizeURI($uri)
    {
        return (string) self::applyFilter($uri, FILTER_SANITIZE_URL);
    }

    /**
     * 
     * @param string $ip - The ip address to validate
     * 
     * @return string
     */
    public static function validateIP($ip)
    {
        return (string) self::applyFilter($ip, FILTER_VALIDATE_IP);
    }

    /**
     * 
     * @param integer $int - The integer to validate
     * 
     * @return integer
     */
    public static function validateINT($integer)
    {
        return (int) self::applyFilter($integer, FILTER_VALIDATE_INT);
    }

    /**
     * 
     * @param integer $int - The integer to sanitize
     * 
     * @return integer
     */
    public static function sanitizeINT($integer)
    {
        return (int) self::applyFilter($integer, FILTER_SANITIZE_NUMBER_INT);
    }


    /**
     * 
     * @param integer $int - The integer to sanitize
     * 
     * @return integer
     */
    public static function sanitizeSTR($string)
    {
        return (string) self::applyFilter($string, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Applies a filter using filter_var
     *
     * @param mixed $value
     * @param int $filter
     * 
     * @return mixed
     */
    protected static function applyFilter($value, int $filter)
    {
        return filter_var($value, $filter);
    }

    // POST VALIDATE & SANITIZE

    /**
     * POST INT
     * 
     * @param string $name
     * 
     * @return integer
     */
    public static function pValidateInt($name)
    {
        return (int) self::post($name, FILTER_VALIDATE_INT);
    }

    /**
     * POST FLOAT
     * 
     * @param string $float
     * 
     * @return float
     */
    public static function pValidateFloat($float)
    {
        return (float) self::post($float, FILTER_VALIDATE_FLOAT);
    }

    /**
     * 
     * @param string $url - The url to sanitize
     * 
     * @return string Return the cleaned string
     */
    public static function pSanitizeURL($url)
    {
        return (string) self::post($url, FILTER_SANITIZE_URL);
    }

    /**
     * 
     * @param string $string
     * 
     * @return string Return the cleaned string
     */
    public static function pSanitizeSTR($string)
    {
        return (string) self::post($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * 
     * @param integer $integer
     * 
     * @return integer Return the cleaned string
     */
    public static function pSanitizeINT($integer)
    {
        return (int) self::post($integer, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * 
     * @param string $email
     * 
     * @return string Return the cleaned string
     */
    public static function pSanitizeMAIL($email)
    {
        return (string) self::post($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * POST
     * 
     * @param string $name
     * @param string $filter FILTER_DEFAULT
     * @param string $require FILTER_REQUIRE_ARRAY
     * 
     * @return string
     */
    public static function post($name, $filter = FILTER_DEFAULT, $require = '')
    {
        return (string) filter_input(INPUT_POST, $name, $filter, $require);
    }

    // GET VALIDATE & SANITIZE

    /**
     * GET INT
     * 
     * @param string $name
     * 
     * @return integer
     */
    public static function gValidateInt($name)
    {
        return (int) self::get($name, FILTER_VALIDATE_INT);
    }

    /**
     * GET FLOAT
     * 
     * @param string $name
     * 
     * @return float
     */
    public static function gValidateFloat($name)
    {
        return (float) self::get($name, FILTER_VALIDATE_FLOAT);
    }

    /**
     * GET
     * 
     * @param string $name
     * @param string $filter FILTER_DEFAULT
     * @param string $require FILTER_REQUIRE_ARRAY
     * 
     * @return string
     */
    public static function get($name, $filter = FILTER_DEFAULT, $option = 0)
    {
        return filter_input(INPUT_GET, $name, $filter, $option);
    }

    // SERVER

    /**
     * SERVER
     * 
     * @see http://php.net/manual/de/function.filter-input.php
     * 
     * @param string $name
     * @param string $filter
     * 
     * @return string
     */
    public static function server($name, $filter = FILTER_DEFAULT)
    {
        return filter_input(INPUT_SERVER, $name, $filter);
    }

    // ARRAY

    /**
     * INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_SESSION or INPUT_ENV
     * 
     * @see http://php.net/manual/de/function.filter-input-array.php
     * 
     * @param mixed $type
     * @param string $name
     * 
     * @return array
     */
    public static function arr($type, $name)
    {
        switch ($type) {
            case "GET":
                $t = INPUT_GET;
                break;
            case "POST":
                $t = INPUT_POST;
                break;
            case "COOKIE":
                $t = INPUT_COOKIE;
                break;
            case "SERVER":
                $t = INPUT_SERVER;
                break;
            case "ENV":
                $t = INPUT_ENV;
                break;
            default:
                $t = $type;
                break;
        }
        return filter_input_array($t, $name);
    }
}
