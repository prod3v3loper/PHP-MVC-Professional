<?php

namespace Model;

use core\classes\db\DBM;

/**
 * Description of Modal
 * 
 * The modal is connected to every other modal and automatically pulls the database table and the class entity.
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Model extends ModelAbstract
{
    /**
     * Database object
     * 
     * @var Object
     */
    protected static $DBH = null;

    /**
     * Database Table placeholder
     * 
     * @var String
     */
    protected static $TABLE = '';

    /**
     * Class entity placeholder
     * 
     * @var String
     */
    protected static $ENTITY = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$DBH = (isset($GLOBALS['DBM_PDO_INST']) ? $GLOBALS['DBM_PDO_INST']->getConnection() : null);
    }

    /**
     * Block clone
     */
    public function __clone()
    {
        //..
    }

    /**
     * Initiate the db and if needed other classes you need on every call of class
     */
    public static function init()
    {
        // Here we need the DB connection
//        self::$DBH = (isset($GLOBALS['DBM_PDO_INST']) ? $GLOBALS['DBM_PDO_INST']->getConnection() : null);
    }

    /**
     * 
     * @return boolean
     */
    public function isOK()
    {
        $return = false;
        if (self::$DBH && self::$TABLE) {
            $return = true;
        }
        return $return;
    }

    /**
     * This function find all by order and returns the object
     * 
     * @uses ::find(); or ::find('WHERE ID = 2 ORDER BY DESC'); etc.
     * 
     * @param string $order
     * @param string $type
     * 
     * @see http://php.net/manual/de/pdostatement.setfetchmode.php
     * 
     * @return object
     */
    public static function find(string $order = '', string $type = '')
    {
        $return = false;
        self::init();
        if (self::$TABLE && is_string($order)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` " . $order;
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY);
            $stmt->execute(array($type));
            $return = $stmt->fetch();
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find all by order and returns the object
     * 
     * @uses ::find(); or ::find('WHERE ID = 2 ORDER BY DESC'); etc.
     * 
     * @param string $order
     * @param string $type
     * 
     * @see http://php.net/manual/de/pdostatement.setfetchmode.php
     * 
     * @return object
     */
    public static function findAll(string $order = '', string $type = '')
    {
        $return = false;
        self::init();
        if (self::$TABLE) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` " . $order;
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY);
            $stmt->execute(array($type));
            $return = $stmt->fetchAll();
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find by id and returns the object
     * 
     * @uses ::findById(2);
     * 
     * @param int $id
     * 
     * @return object
     */
    public static function findById(int $id = 0)
    {
        $return = false;
        self::init();
        if (self::$TABLE) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `ID` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $id
            ));
            $return = $stmt->fetch();
            $stmt = null;
        }

        return $return;
    }

    /**
     * This function find by title and returns the object
     * 
     * @uses ::findByTitle('mytitle');
     * 
     * @param string $title
     * 
     * @return object
     */
    public static function findByTitle(string $title)
    {
        $return = false;
        self::init();
        if (self::$TABLE) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `title` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $title
            ));
            $return = $stmt->fetch();
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find by title and returns the object
     * 
     * @uses ::findByName('myname');
     * 
     * @param string $name
     * 
     * @return object
     */
    public static function findByName(string $name)
    {
        $return = false;
        self::init();
        if (self::$TABLE) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `name` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $name
            ));
            $return = $stmt->fetch();
            $stmt = null;
        }
        return $return;
    }

    /**
     * This find by attribute, you can use string or array
     * 
     * @uses ::findByAttribute('email', '');
     * OR
     * @uses ::findByAttribute(
     *     array('email', ''), 
     * );
     * 
     * @param string|array $keys
     * @param string|array $vals
     * 
     * @return object
     */
    public static function findByAttribute($keys, $vals, $signs = '*')
    {
        $return = false;
        self::init();
        if (self::$TABLE) {

            $where = '';

            if (is_array($keys)) {
                $count = count($keys);
                $where = 'WHERE ';
                for ($i = 0; $i < $count; $i++) {
                    if ($count > ($i + 1)) {
                        $where .= '`' . $keys[$i] . '` = ? AND ';
                    } else {
                        $where .= '`' . $keys[$i] . '` = ?';
                    }
                }
            }
            //..
            else if (is_string($keys)) {
                $where = 'WHERE `' . $keys . '` = ?';
            }

            $sql = 'SELECT ' . $signs . ' FROM `' . self::$TABLE . '` ' . $where;

            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));

            if ($vals && is_array($vals)) {
                $stmt->execute($vals);
            } else if ($vals && is_string($vals)) {
                $stmt->execute(array(
                    $vals
                ));
            }

            $return = $stmt->fetch();

            $stmt = null;
        }

        return $return;
    }

}