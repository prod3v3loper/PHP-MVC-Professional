<?php

namespace Modal;

use core\interfaces\modal\ModalEngine;
use System\DB\DBM;

/**
 * Description of Modal
 * 
 * The modal is connected to every other modal and automatically pulls the database table and the class entity.
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Modal extends ModalAbstract implements ModalEngine {

    /**
     * Database object
     * @var type Object
     */
    protected static $DBH = null;

    /**
     * Database Table placeholder
     * @var type String
     */
    protected static $TABLE = '';

    /**
     * Class entity placeholder
     * @var type String
     */
    protected static $ENTITY = '';

    /**
     * Constructor
     */
    public function __construct() {
        //..
    }

    /**
     * Block clone
     */
    public function __clone() {
        //..
    }

    public static function init() {
        // Here we need the object not the DB connection
        self::$DBH = (isset($GLOBALS['DBM_PDO_INST']) ? $GLOBALS['DBM_PDO_INST'] : null);
    }

    /**
     * 
     * @return boolean
     */
    public function isOK() {
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
     * @param type $order (string)
     * @return type
     */
    public static function find($order = '', $type = '') {

        $return = false;
        self::init();
        if (self::$TABLE && is_string($order)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` " . $order;
            $stmt = self::$DBH->prepare($sql);
            /**
             * Set Fetch Mode
             * @see http://php.net/manual/de/pdostatement.setfetchmode.php
             */
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY); // Fetch all from User class
            $stmt->execute(array($type));
            $return = $stmt->fetch(); // Get all
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find all by order and returns the object
     * 
     * @uses ::find(); or ::find('WHERE ID = 2 ORDER BY DESC'); etc.
     * 
     * @param type $order (string)
     * @return type 
     */
    public static function findAll($order = '', $type = '') {

        $return = false;
        self::init();
        if (self::$TABLE && is_string($order)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` " . $order;
            $stmt = self::$DBH->prepare($sql);
            /**
             * Set Fetch Mode
             * @see http://php.net/manual/de/pdostatement.setfetchmode.php
             */
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY); // Fetch all from User class
            $stmt->execute(array($type));
            $return = $stmt->fetchAll(); // Get all
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find by id and returns the object
     * 
     * @uses ::findById(2);
     * 
     * @param type $id (int)
     * @return type
     */
    public static function findById($id) {

        $return = false;
        self::init();
        if (self::$TABLE && is_int($id)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `ID` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $id
            ));
            $return = $stmt->fetch(); // Get one
            $stmt = null;
        }

        return $return;
    }

    /**
     * This function find by title and returns the object
     * 
     * @uses ::findByTitle('mytitle');
     * 
     * @param type $title (string)
     * @return type
     */
    public static function findByTitle($title) {

        $return = false;
        self::init();
        if (self::$TABLE && is_string($title)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `title` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $title
            ));
            $return = $stmt->fetch(); // Get one
            $stmt = null;
        }
        return $return;
    }

    /**
     * This function find by title and returns the object
     * 
     * @uses ::findByName('myname');
     * 
     * @param type $name (string)
     * @return type
     */
    public static function findByName($name) {

        $return = false;
        self::init();
        if (self::$TABLE && is_string($name)) {
            $sql = "SELECT * FROM `" . self::$TABLE . "` WHERE `name` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::$ENTITY, array(0 => false));
            $stmt->execute(array(
                $name
            ));
            $return = $stmt->fetch(); // Get one
            $stmt = null;
        }
        return $return;
    }

}
