<?php

namespace core\classes\secure;

use core\classes\server\Server,
    core\classes\file\File;

/**
 * Description of HoneyPot
 * 
 * The logger write the data in log file
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class HoneyPot
{

    /**
     * Log on honeypot
     */
    public static function logging()
    {
        $content = "";
        $content .= "[" . date("d.m.Y - H:i:s", time()) . "] " . PHP_EOL;
        $content .= "IP: " . Server::getIP() . PHP_EOL;
        $content .= "AGENT: " . Server::getAgent() . PHP_EOL;
        $content .= "HOST: " . Server::getHost() . PHP_EOL;
        $content .= PHP_EOL;

        $_FILE = new File();
        $_FILE->write($content, HONEYPOT_LOG_FILE);
    }

}