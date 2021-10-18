<?php

namespace Modal\user;

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
class UserModal extends UserValidator
{

    /**
     * 
     * @param type $db
     * @param type $class
     */
    public static function init($db = "user", $class = "\User")
    {

        if (defined('DB_PREFIX')) {
            self::$TABLE = DB_PREFIX . $db; // Database table
        }
        self::$ENTITY = __NAMESPACE__ . $class; // Modal mapper class
    }

    /**
     * SAVE - handels insert and update
     * @return type Boolean
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
     * @return type
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
     * @return boolean
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
     * @return boolean
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
     * @return boolean
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

    // READ

    public static function find($order = '', $type = '')
    {
        self::init();
        return parent::find($order, $type);
    }

    public static function findAll($order = '', $type = '')
    {
        self::init();
        return parent::findAll($order, $type);
    }

    public static function findById($id)
    {
        self::init();
        return parent::findById($id);
    }

    public static function findByName($name)
    {
        self::init();
        return parent::findByName($name);
    }
}
