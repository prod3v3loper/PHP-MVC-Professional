<?php

namespace Model\user;

use core\classes\http\Filter as F,
    core\classes\secure\Mask as M;

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
class User extends UserModel
{
    // ATTRIBUTES //////////////////////////////////////////////////////////////

    /**
     * @var string $firstname
     */
    protected $firstname = '';

    /**
     * @var string $lastname
     */
    protected $lastname = '';

    /**
     * @var string $name
     */
    protected $name = '';

    /**
     * @var string $email
     */
    protected $email = '';

    /**
     * @var string $password
     */
    protected $password = '';

    /**
     * @var string $passHash
     */
    protected $passHash = '';

    /**
     * @var string $passHashAlgo
     */
    protected $passHashAlgo = PASSWORD_BCRYPT;

    /**
     * @var array $passHashOptionen
     */
    protected $passHashOptionen = array(
        'cost' => 12
    );

    /**
     * @var string $oldPassword
     */
    protected $oldPassword = '';

    /**
     * @var integer $role
     */
    protected $role = 3;

    /**
     * @var integer $accept
     */
    protected $accept = 0;

    /**
     * @var string $meta
     */
    protected $meta = '';

    /**
     * @var integer $created
     */
    protected $created = 0;

    /**
     * @var integer $updated
     */
    protected $updated = 0;

    // MAGIC Methods ///////////////////////////////////////////////////////////

    public function __destruct()
    {
        // For clean the storage
        // print "The class " . __CLASS__ . " has been removed from storage";
    }

    public function __clone()
    {
        // Clone blocked this way for security
        // print "They try the class " . __CLASS__ . " to clone";
    }

    /**
     * Call on create a attributte outer the class
     * 
     * @param string $name
     * @param string $value
     */
    // public function __set($name, $value)
    // {
    //     print "The property {$name} should be set to the value {$value} in class " . __CLASS__ . ".";
    // }

    /**
     * Call on read a attributte outer the class
     * 
     * @param string $name
     */
    // public function __get($name)
    // {
    //     print "The property {$name} is to be read from class " . __CLASS__ . ".";
    // }

    /**
     * Call on check if attribute exists
     * 
     * @param string $name
     */
    // public function __isset($name)
    // {
    //     print "Property {$name} exists in class " . __CLASS__ . ".";
    // }

    /**
     * call on delete not exists attribute
     * 
     * @param string $name
     */
    // public function __unset($name)
    // {
    //     print "You are trying to delete an undeclared property of class " . __CLASS__ . ".";
    // }

    /**
     * call on delete not exists attribute
     * 
     * @param string $name
     */
    // public function __invoke($name)
    // {
    //     print "You are trying to call this class " . __CLASS__ . " as a function.";
    // }

    /**
     * Example to string
     */
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

    // SEPCIAL Methods //////////////////////////////////////////////////////////

    public function save()
    {
        return parent::saveObject($this);
    }

    // SETTER Methods ///////////////////////////////////////////////////////////

    public function setFirstname(string $firstname)
    {
        // Sanitize and mask example
        $firstname = F::sanitizeSTR($firstname);
        $firstname = M::encode($firstname, true);

        $this->firstname = ucfirst($firstname);
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = ucfirst($lastname);
    }

    public function setName(string $name)
    {
        $this->name = ucfirst($name);
    }

    public function setEmail(string $email)
    {
        $email = F::sanitizeEmail($email);
        $email = M::encode($email, true);

        // Save the email in other way
        // $this->email = str_replace('@', ' _*_ ', $this->email);

        $this->email = $email;
    }

    public function setPassword(string $pass)
    {
        $this->password = $pass;
    }

    public function setOldPassword(string $oldpass)
    {
        $this->oldPassword = $oldpass;
    }

    public function setMeta(array $meta)
    {
        $this->meta = serialize($meta);
    }

    public function setRole(int $role = 0)
    {
        $this->role = $role;
    }

    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    public function setCreated(int $created)
    {
        // Sanitize and mask example for integer
        $created = F::sanitizeINT($created);
        $created = M::encode($created, true);

        $this->created = $created;
    }

    public function setUpdated(int $updated)
    {
        // Sanitize and mask example for integer
        $updated = F::sanitizeINT($updated);
        $updated = M::encode($updated, true);

        $this->updated = $updated;
    }

    // GETTER Methods ///////////////////////////////////////////////////////////

    public function getFirstname()
    {
        return (string) $this->firstname;
    }

    public function getLastname()
    {
        return (string) $this->lastname;
    }

    public function getName()
    {
        return (string) $this->name;
    }

    public function getEmail()
    {
        // Create the email to the origin
        // $this->email = str_replace('@', ' _*_ ', $this->email);

        return (string) $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function getMeta($mode = false)
    {
        return $mode === false ? unserialize($this->meta) : $this->meta;
    }

    public function getRole()
    {
        return (int) $this->role;
    }

    public function getAccept()
    {
        return $this->accept;
    }

    public function getCreated()
    {
        return (int) $this->created;
    }

    public function getUpdated()
    {
        return (int) $this->updated;
    }

    // EXTRA Methods ///////////////////////////////////////////////////////////

    /**
     * @see https://www.php.net/manual/de/function.password-hash.php
     */
    protected function hashPassword()
    {
        $this->password = password_hash($this->password, $this->passHashAlgo, $this->passHashOptionen);
    }

    /**
     * 
     * @see https://www.php.net/manual/en/function.password-verify.php
     * 
     * @param string $pass
     * @param string $hash
     * 
     * @return boolean
     */
    protected function verifyPassword(string $pass = '', string $hash = '')
    {
        return password_verify($pass, $hash);
    }

    public function login()
    {
        $user = self::findByAttribute(
            array('email'),
            array($this->getEmail()),
            'ID,email,password'
        );

        if ($user) {

            if ($this->verifyPassword($this->getPassword(), $user->getPassword())) {
                session_regenerate_id();
                $_SESSION['user-logged-in'] = true;
                $_SESSION['user-logged-in-since'] = time();
                $_SESSION['user-id'] = $user->getID();
                return true;
            }
        }

        return false;
    }

    /**
     * 
     * @see https://www.php.net/manual/de/reserved.variables.session
     */
    public function logout()
    {
        unset($_SESSION['user-logged-in']);
        unset($_SESSION['user-logged-in-since']);
        unset($_SESSION['user-id']);

        header("Location: " . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/login/', true, 302);
    }

    public function loggedIn()
    {
        if (isset($_SESSION['user-logged-in']) && $_SESSION['user-logged-in'] === true) {
            return true;
        }

        return false;
    }
}
