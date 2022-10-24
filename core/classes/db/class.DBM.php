<?php

namespace core\classes\db;

/**
 * Description of DBM
 * 
 * Singleton data base manager
 * 
 * Objects are always passed in references
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class DBM extends DBM_Abstract
{
    /**
     * Record instance of the database
     * 
     * @var object
     */
    private static $instance = null;

    /**
     * Database connection 
     * 
     * @var object
     */
    private $DBH = null;

    private function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
        //.. Clone not allowed
    }

    /**
     * Initiate the db
     * 
     * @see https://www.php.net/manual/de/pdostatement.fetch.php - PHP Doc pdo mode
     */
    private function init()
    {
        if (DB_DSN && DB_USER && DB_PASS && DB_NAME && DB_PREFIX) {
            
            $DB_OPTIONS = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Returns an array indexed by column name as returned in your result se
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, // Collects data and sends them together to relieve the DB
                \PDO::ATTR_PERSISTENT => true, // Caching for a single user, that speeds up the whole thing
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // Error exeptions
            );

            try {
                $this->DBH = new \PDO(DB_DSN, DB_USER, DB_PASS, $DB_OPTIONS);
                $this->setupDatabase(DB_NAME);
            } catch (\PDOException $e) {
                if (DEBUG) {
                    echo '<div style="color:red;">'
                    . '<pre>' . $e . '</pre>'
                    . '</div>';
                    // Error handling (e.g. email to admin)
                    die();
                }
            }
        }
    }

    /**
     * DB instance
     * 
     * @return object
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * DB connection
     * 
     * @return object
     */
    public function getConnection()
    {
        return $this->DBH;
    }

}