<?php

namespace Model\user;

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
class UserValidator extends \Model\Validator
{
    /**
     * @var integer $minPassLength
     */
    protected $minPassLength = 8;

    /**
     * @var integer $maxPassLength
     */
    protected $maxPassLength = 100;

    /**
     * @var integer $minTextLength
     */
    protected $minTextLength = 3;

    /**
     * @var string $mailcheck
     */
    protected $mailcheck = '';

    /**
     * @var string $passcheck
     */
    protected $passcheck = '';

    /**
     * 
     * @param string $firstname
     */
    public function validateFirstName(string $firstname = '')
    {
        if (empty($firstname)) {
            $this->addError('Please enter your Firstname');
        }

        // Only letters and bind
        $hasLetters = $this->filterRegex($firstname, '/[A-Za-z\-]+/');
        if (!$hasLetters) {
            $this->addError('Please use for your Firstname, only letters');
        } else if (strlen($firstname) < $this->minTextLength) {
            $this->addError(sprintf('The Firstname should be at least %d characters long.', $this->minTextLength));
        }
    }

    /**
     * 
     * @param string $lastname
     */
    public function validateLastName(string $lastname = '')
    {
        if (empty($lastname)) {
            $this->addError('Please enter your Lastname');
        }

        // Only letters and bind
        $hasLetters = $this->filterRegex($lastname, '/[A-Za-z\-]+/');
        if (!$hasLetters) {
            $this->addError('Please use for your Lastname, only letters');
        } else if (strlen($lastname) < $this->minTextLength) {
            $this->addError(sprintf('The Lastname should be at least %d characters long.', $this->minTextLength));
        }
    }

    /**
     * 
     * @param string $name
     */
    public function validateName(string $name = '')
    {
        if (empty($name)) {
            $this->addError('Please enter your Username');
        }

        // Only letters and bind
        $hasLetters = $this->filterRegex($name, '/[A-Za-z\-]+/');
        if (!$hasLetters) {
            $this->addError('Please use for your Username, only letters');
        } else if (strlen($name) < $this->minTextLength) {
            $this->addError(sprintf('The Username should be at least %d characters long.', $this->minTextLength));
        }
    }

    /**
     * 
     * @param string $email
     * 
     * @see http://php.net/manual/de/filter.examples.sanitization.php
     */
    public function validateEmail(string $email = '')
    {
        $this->mailcheck = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($this->mailcheck) or $this->mailcheck == '') {
            $this->addError('Please enter a E-Mail-Address');
        } else if (!filter_var($this->mailcheck, FILTER_VALIDATE_EMAIL)) {
            $this->addError('This E-Mail-Address is invalid');
        } else if (strlen($this->mailcheck) < $this->minTextLength) {
            $this->addError(sprintf('The email should be at least %d characters long.', $this->minTextLength));
        }
        // Create more checkpoints...
    }

    /**
     * 
     * @param string $password
     */
    public function validatePassword(string $password = '')
    {
        $this->passcheck = $password;

        // Determination of all characters used
        $usedChars = count_chars($this->passcheck, 1);

        // There is at least one letter A-Z
        $hasLetters = $this->filterRegex($this->passcheck, '/[A-Z]+/');

        // There is at least one letter a-z
        $hasSmallLetters = $this->filterRegex($this->passcheck, '/[a-z]+/');

        // There is at least one number
        $hasNumbers = $this->filterRegex($this->passcheck, '/\d+/');

        // There is at least one special character
        $hasSpecialChars = $this->filterRegex($this->passcheck, '/[_\W]+/');

        if (empty($this->passcheck)) {
            $this->addError('Please enter your Password');
        } else if (strlen($this->passcheck) < $this->minPassLength) {
            $this->addError(sprintf('The password should be at least %d characters long.', $this->maxPassLength));
        } else if (count($usedChars) < (strlen($this->passcheck) / 2)) {
            $this->addError('The password should contain at least 50 percent different characters.');
        } else if (($hasLetters === false) || ($hasSmallLetters === false) || ($hasNumbers === false) || ($hasSpecialChars === false)) {
            $this->addError('The password should contain uppercase letters, lowercase letters, numbers and special characters.');
        } else if (($this->mailcheck && stristr($this->passcheck, $this->mailcheck) !== false)) {
            $this->addError('The password should not contain any private data that you enter here, e.g. E-mail address');
        }
    }

    /**
     * 
     * @param string $password
     */
    public function validatePasswordCheck(string $password = '')
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
     * @param array $meta
     */
    public function validateMeta(array $meta = array())
    {
        if (is_array($meta)) {
            foreach ($meta as $met => $me) {
                if ($met == 'regagb') {
                    if (1 != $me) {
                        $msg = __('The GTCs were not accepted. You must accept our terms and conditions to register.');
                        FrontView::setMessage('error', $msg);
                        $this->addError($msg);
                    }
                } else {
                    if ($me == '') {
                        $msg = __('The Meta ' . $met . ' field is blank');
                        FrontView::setMessage('error', $msg);
                        $this->addError($msg);
                    }
                }
            }
        }
    }

    /**
     * 
     * @param integer $accept
     */
    public function validateRole(int $role = 0)
    {
        //..
    }

    /**
     * 
     * @param string $accept
     */
    public function validateAccept(string $accept = '')
    {
        //..
    }

    /**
     * CSRF Security token
     * 
     * @param string $token
     */
    public function validateCsrf($token)
    {
        if (false === isset($_SESSION['csrf-token']) || md5($_SESSION['csrf-token']) != $token) {
            $msg = '<b>' . __('Security problem') . ':</b>' . __('Invalid form token discovered') . ' - ' . __('Please try again');
            $this->addError($msg);
        }
    }

    /**
     * CSRF Security time
     */
    public function validateCsrfTime($time)
    {
        if (false === isset($_SESSION['csrf-time']) || isset($_SESSION['csrf-time']) && ($_SESSION['csrf-time']) < $time) {
            $msg = '<b>' . __('Security problem') . ':</b>' . __('Time of security has expired') . ' - ' . __('Please try again');
            $this->addError($msg);
        }
    }
}
