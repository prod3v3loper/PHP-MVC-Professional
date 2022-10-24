<?php

namespace core\classes\server;

/**
 * Description of Server
 * 
 * The abstract server class get the data
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class Server {

    /**
     *
     * @var string 
     */
    protected static $HTTP_X_FORWARDED_FOR = '';

    /**
     *
     * @var string 
     */
    protected static $HTTP_CLIENT_IP = '';

    /**
     *
     * @var string 
     */
    protected static $REMOTE_ADDR = '';

    /**
     *
     * @var string 
     */
    protected static $HTTP_USER_AGENT = '';

    /**
     *  Finds the real IP of the user,
     *  as this can also be hidden behind other information
     *
     *  @return string - Returns the determined IP address
     */
    public static function getIP() {

        $realIP = 'No IP';

        self::$HTTP_X_FORWARDED_FOR = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_DEFAULT);
        self::$HTTP_CLIENT_IP = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_DEFAULT);
        self::$REMOTE_ADDR = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT);

        // if HTTP_X_FORWARDED_FOR exists ?
        if (self::$HTTP_X_FORWARDED_FOR) {
            $realIP = self::$HTTP_X_FORWARDED_FOR;
        }
        // or is HTTP_CLIENT_IP exists ?
        else if (self::$HTTP_CLIENT_IP) {
            $realIP = self::$HTTP_CLIENT_IP;
        }
        // If both of the above do not apply, then determine REMOTE_ADDR
        else {
            // Convert to readable comma separated (123.25.25.123) IP address
            $realIP = long2ip(ip2long(self::$REMOTE_ADDR));
        }

        if (!filter_var($realIP, FILTER_VALIDATE_IP)) {
            $realIP = 'IP not valid';
        }

        return $realIP;
    }

    /**
     *  Finds the user's HTTP user agent, if any
     * 
     *  @return string - Returns the determined HTTP_USER_AGENT
     */
    public static function getAgent() {

        $httpUserAgent = 'No Agent';
        self::$HTTP_USER_AGENT = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT);
        if (self::$HTTP_USER_AGENT) {
            $httpUserAgent = self::$HTTP_USER_AGENT;
        }
        return $httpUserAgent;
    }

    /**
     * Get the host fi exists
     * 
     * @return string - The Hostname
     */
    public static function getHost() {

        return gethostbyaddr(Server::getIP());
    }

}