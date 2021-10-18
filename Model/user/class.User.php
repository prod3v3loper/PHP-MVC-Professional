<?php

namespace Modal\user;

/**
 * Description of User
 * 
 * Create more models and validators to your classes, this is a example for user
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class User extends UserModal
{

    /**
     * @var String Firstname
     */
    protected $firstname = '';

    /**
     * @var String Lastname
     */
    protected $lastname = '';

    /**
     * @var String Name
     */
    protected $name = '';

    /**
     * @var String Email
     */
    protected $email = '';

    /**
     * @var String Password
     */
    protected $password = '';

    /**
     *
     * @var String Password Hash
     */
    protected $passHash = '';

    /**
     *
     * @var String Password crypto
     */
    protected $passHashAlgo = PASSWORD_BCRYPT;

    /**
     * 
     * @var Array Password Hash options
     */
    protected $passHashOptionen = array(
        'cost' => 12
    );

    /**
     * @var String Old Password
     */
    protected $oldPassword = '';

    /**
     * @var Integer Role
     */
    protected $role = 3;

    /**
     * @var Integer Accept
     */
    protected $accept = 0;

    /**
     * @var Array Meta
     */
    protected $meta = '';

    /**
     * @var Integer Date
     */
    protected $created = 0;

    /**
     * @var Integer Update
     */
    protected $updated = 0;

    /**
     * Call on instance the object
     */
    public function __construct()
    {

        parent::__construct(); // Inherited Constructor
    }

    /**
     * Call on destruct of the object from memory
     */
    public function __destruct()
    {
        //        print "Die Klasse " . __CLASS__ . " wurde aus dem spichert entfernt";
    }

    /**
     * Call on copy of the object
     * @todo Create security table and save in db nt allowed accesses
     */
    public function __clone()
    {
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

    public function __toString()
    {
        $str = "I am  ";
        if ($this->getName()) {
            $str .= $this->getName();
        } else {
            $str .= 'Guest';
        }
        return $str;
    }

    // SETTER Methoden /////////////////////////////////////////////////////////

    public function setFirstname($firstname)
    {
        $this->firstname = ucfirst($firstname);
    }

    public function setLastname($lastname)
    {
        $this->lastname = ucfirst($lastname);
    }

    public function setName($name)
    {
        if (is_string($name) && strlen($name) > 0 && strlen($name) <= 100) {
            $this->name = ucfirst($name);
        }
    }

    public function setEmail($email)
    {
        if (is_string($email) && strlen($email) > 0 && strlen($email) <= 255) {
            //            $this->email = str_replace('@', ' _*_ ', $this->email);
            $this->email = $email;
        }
    }

    public function setPassword($pass)
    {
        if (is_string($pass) && strlen($pass) > 0 && strlen($pass) <= 255) {
            $this->password = $pass;
            $this->hashPassword();
        }
    }

    protected function hashPassword()
    {
        if (!empty($this->password)) {
            $this->passHash = password_hash($this->password, $this->passHashAlgo, $this->passHashOptionen);
        }
    }

    public function setOldPassword($oldpass)
    {
        if (is_string($oldpass) && strlen($oldpass) > 0 && strlen($oldpass) <= 255) {
            $this->oldPassword = $oldpass;
        }
    }

    public function setMeta($meta)
    {
        if (is_array($meta)) {
            $this->meta = serialize($meta);
        } else {
            $this->meta = serialize($meta);
        }
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    // GETTER Methoden /////////////////////////////////////////////////////////

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        //        $this->email = str_replace('@', ' _*_ ', $this->email);
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function verifyPasswordHash($password)
    {
        return password_verify($password, $this->passHash);
    }

    public function checkPasswordNeedsRehash()
    {
        return password_needs_rehash($this->passHash, $this->passHashAlgo, $this->passHashOptionen);
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function getMeta()
    {
        return unserialize($this->meta);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAccept()
    {
        return $this->accept;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}
