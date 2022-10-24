<?php

namespace Model\user;

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
     * @var array $meta
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

    public function __destruct()
    {
        //        print "Die Klasse " . __CLASS__ . " wurde aus dem spichert entfernt";
    }

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

    /**
     * 
     * @param string $firstname
     */
    public function setFirstname(string $firstname = '')
    {
        $this->firstname = ucfirst($firstname);
    }

    /**
     * 
     * @param string $lastname
     */
    public function setLastname(string $lastname = '')
    {
        $this->lastname = ucfirst($lastname);
    }

    /**
     * Use the setter methods for check again before assign
     * 
     * @param string $name
     */
    public function setName(string $name = '')
    {
        if (strlen($name) > 0 && strlen($name) <= 100) {
            $this->name = ucfirst($name);
        }
    }

    /**
     * 
     * @param string $email
     */
    public function setEmail(string $email = '')
    {
        if (is_string($email) && strlen($email) > 0 && strlen($email) <= 255) {
            //            $this->email = str_replace('@', ' _*_ ', $this->email);
            $this->email = $email;
        }
    }

    /**
     * 
     * @param string $pass
     */
    public function setPassword(string $pass = '')
    {
        if (is_string($pass) && strlen($pass) > 0 && strlen($pass) <= 255) {
            $this->password = $pass;
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

    /**
     * 
     * @param int $role
     */
    public function setRole(int $role = 0)
    {
        $this->role = $role;
    }

    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    /**
     * 
     * @param int $created
     */
    public function setCreated(int $created = 0)
    {
        $this->created = $created;
    }

    /**
     * 
     * @param int $updated
     */
    public function setUpdated(int $updated = 0)
    {
        $this->updated = $updated;
    }

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
        //        $this->email = str_replace('@', ' _*_ ', $this->email);
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

    public function getMeta()
    {
        return unserialize($this->meta);
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

    /**
     * 
     * @return boolean
     */
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
     * @see https://www.php.net/manual/de/reserved.variables.session
     */
    public function logout()
    {
        unset($_SESSION['user-logged-in']);
        unset($_SESSION['user-logged-in-since']);
        unset($_SESSION['user-id']);

        header("Location: " . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/login/', true, 302);
    }

    /**
     * 
     * @return boolean
     */
    public function loggedIn()
    {
        if (isset($_SESSION['user-logged-in']) && $_SESSION['user-logged-in'] === true) {
            return true;
        }

        return false;
    }

}