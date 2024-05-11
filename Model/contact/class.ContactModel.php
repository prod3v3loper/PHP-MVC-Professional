<?php

namespace Model\contact;

/**
 * Description of Contact Model
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class ContactModel extends ContactValidator
{
    /**
     * INIT
     * 
     * @param string $db
     * @param string $class
     */
    public static function init($db = "contact", $class = "\Contact")
    {
        parent::init();
        if (defined('DB_PREFIX')) {
            self::$TABLE = DB_PREFIX . $db; // Database table
        }
        self::$ENTITY = __NAMESPACE__ . $class; // Modal mapper class
    }

    /**
     * SAVE
     * 
     * @return boolean
     */
    public function saveObject(Contact $contact)
    {
        if ($this->ID == 0) {
            $return = $this->insert($contact);
        } else if ($this->ID > 0) {
            $return = $this->update($contact);
        }
        return $return;
    }

    /**
     * REMOVE
     * 
     * @return boolean
     */
    public function remove()
    {
        if ($this->ID > 0) {
            $return = $this->delete();
        }
        return $return;
    }

    /**
     * INSERT
     * 
     * @return boolean
     */
    private function insert(Contact $contact)
    {
        self::init();
        $return = false;
        if ($this->isOK()) {
            $sql = "INSERT INTO `" . self::$TABLE . "` (`name`,`email`,`subject`,`message`,`created`) VALUES (?,?,?,?,?)";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $contact->name,
                $contact->email,
                $contact->subject,
                $contact->message,
                time()
            ));
            $return = $stmt ? true : false;
            $stmt = null; // Clean statement
        }
        return $return;
    }

    /**
     * UPDATE
     * 
     * @return boolean
     */
    private function update(Contact $contact)
    {
        self::init();
        $return = false;
        if ($this->isOK()) {
            $sql = "UPDATE `" . self::$TABLE . "` SET `name`=?, `email`=?, `subject`=?, `message`=? WHERE `ID`=?";
            $stmt = self::$DBH->prepare($sql);
            $stmt->execute(array(
                $contact->name,
                $contact->email,
                $contact->subject,
                $contact->message,
                time(),
                $this->ID
            ));
            $return = ($stmt->rowCount() <= 0) ? false : true;
            $stmt = null; // Clean statement
        }
        return $return;
    }

    /**
     * DELETE
     * 
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
            $stmt = null; // Clean statement
        }
        return $return;
    }

    public static function findById(int $id = 0)
    {
        self::init();
        return parent::findById($id);
    }
}
