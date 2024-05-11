<?php

namespace core\classes\db;

/**
 * Description of DBM_Abstract
 * 
 * Helper for data base manager
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class DBM_Abstract
{
    /**
     * 
     * @param string $dbname
     */
    protected function setupDatabase(DBM $dbm, string $dbname = '',)
    {
        // Create default database if not exists
        $this->createDatabase($dbm, $dbname);

        // Create default tables if not exists
        $this->createUserTable($dbm);
        $this->createContactTable($dbm);
        $this->createErrorTable($dbm);
    }

    /**
     * This function create the Database for the project
     * 
     * @param string $dbname
     */
    protected function createDatabase(DBM $dbm, string $dbname = '')
    {
        $createDB = "CREATE DATABASE IF NOT EXISTS `" . $dbname . "`";
        $dbm->getConnection()->prepare($createDB);
    }

    /**
     * This function create the user table, for login etc.
     */
    protected function createUserTable(DBM $dbm)
    {
        $userTable = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user` (
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
                                created INT(11) NOT NULL, 
                                updated INT(11) NOT NULL
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

        $stmt = $dbm->getConnection()->prepare($userTable);
        $stmt->execute();
    }

    /**
     * This function create the user table, for login etc.
     */
    protected function createContactTable(DBM $dbm)
    {
        $contactTable = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contact` (
                                `ID` INT(11) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(100) NOT NULL, 
                                email VARCHAR(255) NOT NULL, 
                                subject VARCHAR(255) NOT NULL, 
                                message TEXT NOT NULL, 
                                created INT(11) NOT NULL 
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

        $stmt = $dbm->getConnection()->prepare($contactTable);
        $stmt->execute();
    }

    /**
     * This function create the user table, for login etc.
     */
    protected function createErrorTable(DBM $dbm)
    {
        $errorTable = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "error` (
                                `ID` INT(11) AUTO_INCREMENT PRIMARY KEY, 
                                type TEXT NOT NULL, 
                                error TEXT NOT NULL, 
                                script VARCHAR(255) NOT NULL, 
                                line INT(11) NOT NULL, 
                                created INT(11) NOT NULL
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

        $stmt = $dbm->getConnection()->prepare($errorTable);
        $stmt->execute();
    }
}
