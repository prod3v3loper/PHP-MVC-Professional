<?php

namespace Modal\user;

// Needed classes
use View\FrontView;

/**
 * Description of User Validator
 * 
 * In the user class you can check all inputs, so everything about the object reinkommt its valid and correct before it is stored
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class UserValidator extends \Modal\Validator {

    /**
     *
     * @var type 
     */
    protected $email = '';

    /**
     *
     * @var type 
     */
    protected $name = '';

    /**
     *
     * @var type 
     */
    protected $password = '';

    /**
     *
     * @var type 
     */
    protected $minLength = 8;

    /**
     * 
     * @param type $email
     */
    public function validateEmail($email) {

        // http://php.net/manual/de/filter.examples.sanitization.php
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($email) OR $email == '') {
            $msg = __('Please enter a E-Mail-Address');
            $this->addError($msg);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = __('This E-Mail-Address is invalid');
            $this->addError($msg);
        }
        // Create more checkpoints...
    }

    /**
     * 
     * @param type $name
     */
    public function validateName($name) {
        
        if (empty($name)) {
            $msg = __('Please enter your Username');
            $this->addError($msg);
        }

        // Only letters and bind
        $hasLetters = $this->filterRegex($name, '/[A-Za-z\-]+/');
        if (!$hasLetters) {
            $msg = __('Please use for your Username, only letters');
            $this->addError($msg);
        }
    }

    /**
     * 
     * @param type $password
     */
    public function validatePassword($password) {

        $this->password = $password;

        // Ermittlung aller benutzten Zeichen
        $usedChars = count_chars($this->password, 1);

        // Es kommt min. ein Buchstabe A-Z vor
        $hasLetters = $this->filterRegex($this->password, '/[A-Z]+/');

        // Es kommt min. ein Buchstabe a-z vor
        $hasSmallLetters = $this->filterRegex($this->password, '/[a-z]+/');

        // Es kommt min. eine Zahl vor
        $hasNumbers = $this->filterRegex($this->password, '/\d+/');

        // Es kommt min. ein Sonderzeichen vor
        $hasSpecialChars = $this->filterRegex($this->password, '/[_\W]+/');

        if (empty($this->password)) {
            $msg = __('Please enter your Password');
            $this->addError($msg);
//        } else if (strlen($this->password) < $this->minLength) {
//            $this->addError(sprintf('Das Passwort sollte mindestens %d Zeichen lang sein.', $this->minLength));
//        } else if (count($usedChars) < (strlen($this->password) / 2)) {
//            $this->addError('Das Passwort sollte zu mindestens 50 Prozent unterschiedliche Zeichen enthalten.');
//        } else if (($hasLetters === false) || ($hasSmallLetters === false) || ($hasNumbers === false) || ($hasSpecialChars === false)) {
//            $this->addError('Das Passwort sollte Großbuchstaben, Kleinbuchstaben, Zahlen und Sonderzeichen enthalten.');
        } else if (($this->email && stristr($this->password, $this->email) !== false)) {
            $msg = __('The password should not contain any private data that you enter here, e.g. E-mail address');
            $this->addError($msg);
        }
    }

    /**
     * 
     * @param type $password
     */
    public function validatePasswordCheck($password) {

        if (!$this->password) {
            $msg = __('Please enter a Password recovery');
            $this->addError($msg);
        }

        if ($this->password !== $password) {
            $msg = __('The entered Passwords do not match');
            $this->addError($msg);
        }
    }

    /**
     * 
     * @param type $password
     */
    public function validateOldPassword($password) {

        if ($this->password !== $password) {
            $msg = __('The entered Passwords do not match');
            $this->addError($msg);
        }
    }

    /**
     * 
     * @param type $accept
     */
    public function validateAccept($accept) {
        
    }

    /**
     * 
     * @param type $token
     */
    public function validateCsrfToken($token) {

        $maxTime = 20;

        if (false === isset($_SESSION['csrf-token']) || md5($_SESSION['csrf-token']) != $token) {
            $msg = __('<b>Security problem:</b> Invalid form token discovered. Please try again.');
            $this->addError($msg);
        }

        if (isset($_SESSION['csrf-time']) && ($_SESSION['csrf-time'] + $maxTime) < time()) {
            $msg = __('<b>Security problem:</b> Invalid form token discovered, the time of the token has expired. Please try again.');
            $this->addError($msg);
        }
    }

}
