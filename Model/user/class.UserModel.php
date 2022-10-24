<?php

namespace Model\user;

/**
 * Description of User Modal
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class UserModel extends UserValidator
{
    public function __construct()
    {
        parent::__construct(); // Inherited Constructor
    }

    /**
     * 
     * @param string $db
     * @param string $class
     */
    public static function init(string $db = "user", string $class = "\User")
    {
        if (defined('DB_PREFIX')) {
            self::$TABLE = DB_PREFIX . $db; // Database table
        }
        self::$ENTITY = __NAMESPACE__ . $class; // Modal mapper class
    }

    /**
     * SAVE - handels insert and update
     * 
     * @return bool
     */
    public function saveObject()
    {
        if ($this->ID == 0) {
            $return = $this->insert();
        } else if ($this->ID > 0) {
            $return = $this->update();
        }
        return $return;
    }

    /**
     * REMOVE
     * 
     * @return bool
     */
    public function remove()
    {
        if ($this->ID > 0) {
            $return = $this->delete();
        }
        return $return;
    }

    /**
     * CREATE
     * 
     * @return bool
     */
    private function insert()
    {
        self::init();
        $return = false;
        if ($this->isOK()) {
            $sql = "INSERT INTO `" . self::$TABLE . "` (`firstname`,`lastname`,`name`,`email`,`password`,`oldPassword`,`meta`,`role`,`accept`,`created`,`updated`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $this->firstname,
                $this->lastname,
                $this->name,
                $this->email,
                $this->password,
                $this->oldPassword,
                $this->meta,
                $this->role,
                $this->accept,
                time(),
                time()
            ));
            $return = $stmt ? true : false;
        }
        return $return;
    }

    /**
     * UPDATE
     * 
     * @return bool
     */
    private function update()
    {
        self::init();
        $return = false;

        if ($this->isOK()) {
            $sql = "UPDATE `" . self::$TABLE . "` SET `firstname` = ?, `lastname` = ?, `name` = ?, `email` = ?, `meta` = ?, `role` = ?, `accept` = ?, `updated` = ? WHERE `ID` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $this->firstname,
                $this->lastname,
                $this->name,
                $this->email,
                $this->meta,
                $this->role,
                $this->accept,
                time(),
                $this->ID,
            ));
            $return = ($stmt->rowCount() <= 0) ? false : true;
        }
        return $return;
    }

    /**
     * DELETE
     * 
     * @return bool
     */
    private function delete()
    {
        self::init();
        $return = false;
        if ($this->isOK()) {
            $sql = 'DELETE FROM ' . self::$TABLE . ' WHERE ID = ?';
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $this->ID
            ));
            $return = ($stmt->rowCount() > 0) ? true : false;
        }
        return $return;
    }

    public static function find(string $order = '', string $type = '')
    {
        self::init();
        return parent::find($order, $type);
    }

    public static function findAll(string $order = '', string $type = '')
    {
        self::init();
        return parent::findAll($order, $type);
    }

    public static function findById(int $id = 0)
    {
        self::init();
        return parent::findById($id);
    }

    public static function findByName($name)
    {
        self::init();
        return parent::findByName($name);
    }

    public static function findByAttribute($keys, $vals, $signs = '*')
    {
        self::init();
        return parent::findByAttribute($keys, $vals, $signs);
    }

}