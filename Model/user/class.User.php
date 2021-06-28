<?php

namespace Modal\user;

/**
 * Description of User
 * 
 * Create more models and validators to your classes, this is a example for user
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class User extends UserModal {

    /**
     * Firstname
     * @var type String
     */
    protected $firstname = '';

    /**
     * Lastname
     * @var type String
     */
    protected $lastname = '';

    /**
     * Username
     * @var type String
     */
    protected $name = '';

    /**
     * Usermail
     * @var type String
     */
    protected $email = '';

    /**
     * Userpass
     * @var type String
     */
    protected $password = '';

    /**
     *
     * @var type String
     */
    protected $passHash = '';

    /**
     *
     * @var type String
     */
    protected $passHashAlgo = PASSWORD_BCRYPT;

    /**
     * 
     * @var type String
     */
    protected $passHashOptionen = array(
        'cost' => 12
    );

    /**
     * User Old Password
     * @var type Hash
     */
    protected $oldPassword = '';

    /**
     * User Accept
     * @var type Integer
     */
    protected $role = 3;

    /**
     * User Accept
     * @var type Integer
     */
    protected $accept = 0;

    /**
     * User Accept
     * @var type String
     */
    protected $oauth = '';

    /**
     * User Meta
     * @var type Array
     */
    protected $meta = '';

    /**
     * User Register Date
     * @var type Integer
     */
    protected $created = 0;

    /**
     * User Update
     * @var type Integer
     */
    protected $updated = 0;

    /**
     * Project
     * @var type 
     */
    protected $project = array();

    /**
     * Call on instance the object
     */
    public function __construct() {

        parent::__construct(); // Inherited Constructor
    }

    /**
     * Call on destruct of the object from memory
     */
    public function __destruct() {
//        print "Die Klasse " . __CLASS__ . " wurde aus dem spichert entfernt";
    }

    /**
     * Call on copy of the object
     * @todo Create security table and save in db nt allowed accesses
     */
    public function __clone() {
//        print "Sie versuchen die Klasse " . __CLASS__ . " zu klonen";
    }

    /**
     * Call on create a attributte outer the class
     * @todo Create security table and save in db nt allowed accesses
     * @param type $name
     * @param type $value
     */
//    public function __set($name, $value) {
////        print "Die Eigenschaft {$name} soll auf den Wert {$value} in Klasse " . __CLASS__ . " gesetzt werden.";
//    }
//
//    /**
//     * Call on read a attributte outer the class
//     * @todo Create security table and save in db nt allowed accesses
//     * @param type $prop
//     */
//    public function __get($name) {
////        print "Die Eigenschaft {$name} soll aus Klasse " . __CLASS__ . " ausgelesen werden.";
//    }
//    
//    /**
//     * Call on check if attribute exists
//     * @param type $name
//     */
//    public function __isset($name) {
////        print "Ist die Eigenschaft {$name} in Klasse " . __CLASS__ . " vorhanden.";
//    }
//    
//    /**
//     * call on delete not exists attribute
//     */
//    public function __unset($name) {
////        print "Du versuchst eine nicht deklarierte Eigenschaft der Klasse " . __CLASS__ . " zu löschen.";
//    }
    //    /**
//     * call on delete not exists attribute
//     */
//    public function __invoke($name) {
////        print "Du versuchst diese Klasse " . __CLASS__ . " als funktion aufzurufen.";
//    }

    public function __toString() {

        $str = "Ich bin user ";
        if ($this->getName()) {
            $str .= $this->getName();
        } else {
            $str .= 'Gast';
        }
        return $str;
    }

    // SETTER Methoden /////////////////////////////////////////////////////////

    public function setFirstname($firstname) {
        $this->firstname = ucfirst(_MBT_Mask::encode($firstname));
    }

    public function setLastname($lastname) {
        $this->lastname = ucfirst(_MBT_Mask::encode($lastname));
    }

    public function setName($name) {
        if (is_string($name) && strlen($name) > 0 && strlen($name) <= 100) {
            $this->name = ucfirst(_MBT_Mask::encode($name));
        }
    }

    public function setEmail($email) {
        if (is_string($email) && strlen($email) > 0 && strlen($email) <= 255) {
//            $this->email = str_replace('@', ' _*_ ', $this->email);
            $this->email = $email;
        }
    }

    public function setPassword($pass) {
        if (is_string($pass) && strlen($pass) > 0 && strlen($pass) <= 255) {
            $this->password = md5($pass . MBT_LOGIN_HASH_SALT);
            $this->hashPassword();
        }
    }

    protected function hashPassword() {
        if (!empty($this->password)) {
            $this->passHash = password_hash($this->password, $this->passHashAlgo, $this->passHashOptionen);
        }
    }

    public function setOldPassword($oldpass) {
        if (is_string($oldpass) && strlen($oldpass) > 0 && strlen($oldpass) <= 255) {
            $this->oldPassword = md5($oldpass . MBT_LOGIN_HASH_SALT);
        }
    }

    public function setMeta($meta) {
        if (is_array($meta)) {
            $this->meta = serialize($meta);
        } else {
            $this->meta = serialize($meta);
        }
    }

    public function setRole($role) {
        $roleINT = (int) trim($role);
        if (is_int($roleINT) && strlen($roleINT) > 0 && strlen($roleINT) <= 1) {
            $this->role = $roleINT;
        }
    }

    public function setAccept($accept) {
        $acceptINT = (int) trim($accept);
        if (is_int($acceptINT) && strlen($acceptINT) > 0 && strlen($acceptINT) <= 1) {
            $this->accept = $acceptINT;
        }
    }

    public function setOauth($oauth) {
        $oauthSTR = (string) trim($oauth);
        if (is_string($oauthSTR)) {
            $this->oauth = $oauthSTR;
        }
    }

    public function setCreated($created) {
        $createdINT = (int) trim($created);
        $this->created = $createdINT;
    }

    public function setUpdated($updated) {
        $updatedINT = (int) trim($updated);
        $this->updated = $updatedINT;
    }

    public function setProjects(array $projects) {
        $this->project = $projects;
    }

    public function addProjects(Project $project) {
        $this->project[] = $project;
    }

    // GETTER Methoden /////////////////////////////////////////////////////////

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
//        $this->email = str_replace('@', ' _*_ ', $this->email);
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function verifyPasswordHash($password) {
        return password_verify($password, $this->passHash);
    }

    public function checkPasswordNeedsRehash() {
        return password_needs_rehash($this->passHash, $this->passHashAlgo, $this->passHashOptionen);
    }

    public function getOldPassword() {
        return $this->oldPassword;
    }

    public function getMeta() {
        return unserialize($this->meta);
    }

    public function getRole($mod = false) {
        $return = false;
        if ($mod && $this->role) {
            $roleObj = Role::findByAttribute(array("id"), array($this->role));
            if ($roleObj) {
                $return = $roleObj->getName();
            }
        } else if ($this->role) {
            $return = $this->role;
        }
        return $return;
    }

    public function getAccept() {
        return $this->accept;
    }

    public function getOauth() {
        return $this->oauth;
    }

    public function getProjects() {
        return $this->project;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getUpdated() {
        return $this->updated;
    }

}
