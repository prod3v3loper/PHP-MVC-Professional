<?php

namespace core\classes\server;

use core\classes\http\Filter as F;

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
abstract class Server
{
    /**
     *  Finds the real IP of the user,
     *  as this can also be hidden behind other information
     *
     *  @return string - Returns the determined IP address
     */
    public static function getIP()
    {
        $keys = ['HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        foreach ($keys as $key) {
            $ip = F::server($key);
            if ($ip && F::validateIP($ip)) {
                return $ip;
            }
        }
        return '0.0.0.0'; // Fallback
    }

    /**
     *  Finds the user's HTTP user agent, if any
     * 
     *  @return string - Returns the determined HTTP_USER_AGENT
     */
    public static function getAgent()
    {
        return F::server('HTTP_USER_AGENT') ? F::server('HTTP_USER_AGENT') : 'No Agent';
    }

    /**
     * Get the host fi exists
     * 
     * @return string - The Hostname
     */
    public static function getHost()
    {
        return gethostbyaddr(self::getIP());
    }
}
