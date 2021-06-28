<?php

/**
 * Add more class folders in class and use it with namespase use
 */

namespace System\DB;

/**
 * Singleton DB
 * Objects are always passed in references
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class DBM {

    /**
     * Record instance of the database
     * 
     * @var type object
     */
    static private $instance = null;

    /**
     * Database connection 
     * 
     * @var type object
     */
    private $DBH = null;

    /**
     * Constructor init
     */
    private function __construct() {

        $this->init();
    }

    /**
     * Prevent db clone
     */
    private function __clone() {

        //..
    }

    /**
     * Initiate the db
     */
    private function init() {

        // PDO options
        $DB_OPTIONS = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Enable database data as an object
            \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, // Collects data and sends them together to relieve the DB
            \PDO::ATTR_PERSISTENT => true, // Caching for a single user, that speeds up the whole thing
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // Error exeptions
        );

        try {

            // PDO connect with db
            $this->DBH = new \PDO(DB_DSN, DB_USER, DB_PASS, $DB_OPTIONS);

            // Create project tables
            $createTable = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user` (
                                `ID` INT(11) AUTO_INCREMENT PRIMARY KEY, 
                                firstname VARCHAR(255) NOT NULL, 
                                lastname VARCHAR(255) NOT NULL, 
                                name VARCHAR(100) NOT NULL, 
                                email VARCHAR(255) NOT NULL, 
                                password VARCHAR(255) NOT NULL, 
                                oldPassword VARCHAR(255) NOT NULL, 
                                meta TEXT NOT NULL, 
                                role TINYINT(1) NOT NULL, 
                                accept TINYINT(1) NOT NULL, 
                                oauth VARCHAR(100) NOT NULL, 
                                created INT(11) NOT NULL, 
                                updated INT(11) NOT NULL
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

            $stmt = $this->DBH->prepare($createTable);
            if (!$stmt->execute()) {
//                $stmt->errorInfo();
            }
            
            // Creat more project tables
            
        } catch (\PDOException $e) {

            // Catch errors
            echo '<div style="color:red;">'
            . '<pre>' . $e . '</pre>'
            . '</div>';
            
            // Error handling (e.g. email to admin)
            die();
        }
    }

    /**
     * DB instance
     * 
     * @return type object
     */
    static public function get_instance() {

        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * DB connection
     * 
     * @return type object
     */
    public function get_connection() {

        return $this->DBH;
    }

}
