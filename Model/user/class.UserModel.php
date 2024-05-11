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
    /**
     * INIT
     * 
     * @param string $db
     * @param string $class
     */
    public static function init(string $db = "user", string $class = "\User")
    {
        parent::init();
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
    public function saveObject(User $user)
    {
        $return = false;
        if ($this->ID == 0) {
            $return = $this->insert($user);
        } else if ($this->ID > 0) {
            $return = $this->update($user);
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
        $return = false;
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
    private function insert(User $user)
    {
        self::init();
        $return = false;
        if ($this->isOK()) {
            $sql = "INSERT INTO `" . self::$TABLE . "` (`firstname`,`lastname`,`name`,`email`,`password`,`oldPassword`,`meta`,`role`,`accept`,`created`,`updated`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $user->getFirstname(),
                $user->getLastname(),
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getOldPassword(),
                $user->getMeta(),
                $user->getRole(),
                $user->getAccept(),
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
    private function update(User $user)
    {
        self::init();
        $return = false;

        if ($this->isOK()) {
            $sql = "UPDATE `" . self::$TABLE . "` SET `firstname` = ?, `lastname` = ?, `name` = ?, `email` = ?, `password` = ?, `oldPassword` = ?, `meta` = ?, `role` = ?, `accept` = ?, `updated` = ? WHERE `ID` = ?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $user->getFirstname(),
                $user->getLastname(),
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getOldPassword(),
                $user->getMeta(),
                $user->getRole(),
                $user->getAccept(),
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

    public static function findById(int $id)
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
