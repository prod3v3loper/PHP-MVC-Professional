<?php

namespace Modal\user;

// Needed classes
use View\FrontView;

/**
 * Description of User Validator
 * 
 * In the user class you can check all inputs, so everything about the object reinkommt its valid and correct before it is stored
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class UserValidator extends \Modal\Validator
{
    /**
     *
     * @var String Default min length
     */
    protected $minLength = 8;

    protected $passcheck = '';

    protected $mailcheck = '';

    /**
     * 
     * @param type $email
     */
    public function validateEmail($email)
    {
        // http://php.net/manual/de/filter.examples.sanitization.php
        $this->mailcheck = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($email) or $email == '') {
            $this->addError('Please enter a E-Mail-Address');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('This E-Mail-Address is invalid');
        }
        // Create more checkpoints...
    }

    /**
     * 
     * @param type $name
     */
    public function validateName($name)
    {
        if (empty($name)) {
            $this->addError('Please enter your Username');
        }

        // Only letters and bind
        $hasLetters = $this->filterRegex($name, '/[A-Za-z\-]+/');
        if (!$hasLetters) {
            $this->addError('Please use for your Username, only letters');
        }
    }

    /**
     * 
     * @param type $password
     */
    public function validatePassword($password)
    {
        $this->passcheck = $password;

        // Ermittlung aller benutzten Zeichen
        $usedChars = count_chars($password, 1);

        // Es kommt min. ein Buchstabe A-Z vor
        $hasLetters = $this->filterRegex($password, '/[A-Z]+/');

        // Es kommt min. ein Buchstabe a-z vor
        $hasSmallLetters = $this->filterRegex($password, '/[a-z]+/');

        // Es kommt min. eine Zahl vor
        $hasNumbers = $this->filterRegex($password, '/\d+/');

        // Es kommt min. ein Sonderzeichen vor
        $hasSpecialChars = $this->filterRegex($password, '/[_\W]+/');

        if (empty($password)) {
            $this->addError('Please enter your Password');
            //        } else if (strlen($this->password) < $this->minLength) {
            //            $this->addError(sprintf('Das Passwort sollte mindestens %d Zeichen lang sein.', $this->minLength));
            //        } else if (count($usedChars) < (strlen($this->password) / 2)) {
            //            $this->addError('Das Passwort sollte zu mindestens 50 Prozent unterschiedliche Zeichen enthalten.');
            //        } else if (($hasLetters === false) || ($hasSmallLetters === false) || ($hasNumbers === false) || ($hasSpecialChars === false)) {
            //            $this->addError('Das Passwort sollte Großbuchstaben, Kleinbuchstaben, Zahlen und Sonderzeichen enthalten.');
        } else if (($this->mailcheck && stristr($password, $this->mailcheck) !== false)) {
            $this->addError('The password should not contain any private data that you enter here, e.g. E-mail address');
        }
    }

    /**
     * 
     * @param type $password
     */
    public function validatePasswordCheck($password)
    {
        if (!$password) {
            $this->addError('Please enter a Password recovery');
        }

        if ($this->passcheck !== $password) {
            $this->addError('The entered Passwords do not match with Password recovery');
        }
    }

    /**
     * 
     * @param type $accept
     */
    public function validateAccept($accept)
    {
        //..
    }

    /**
     * 
     * @param type $token
     */
    public function validateCsrfToken($token)
    {
        $maxTime = 20;

        if (false === isset($_SESSION['csrf-token']) || md5($_SESSION['csrf-token']) != $token) {
            $this->addError('<b>Security problem:</b> Invalid form token discovered. Please try again.');
        }

        if (isset($_SESSION['csrf-time']) && ($_SESSION['csrf-time'] + $maxTime) < time()) {
            $this->addError('<b>Security problem:</b> Invalid form token discovered, the time of the token has expired. Please try again.');
        }
    }
}
