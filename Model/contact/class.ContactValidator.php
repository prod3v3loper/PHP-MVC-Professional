<?php

namespace Model\contact;

/**
 * Description of Contact Validator
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class ContactValidator extends \Model\Validator
{
    /**
     * 
     * @param type $name
     */
    public function validateName(string $name = '')
    {
        $hasLetters = $this->filterRegex($name, '/[A-Za-z\-]+/');
        if (empty($name)) {
            $this->addError(__('Please enter your Name'));
        } else if (strlen($name) < 3) {
            $this->addError(__('Name must be longer then') . 3 . __('signs'));
        } else if (!$hasLetters) {
            $this->addError(__('Please use for Name, only letters'));
        }
    }

    /**
     * 
     * @see http://php.net/manual/de/filter.examples.sanitization.php
     * 
     * @param string $email
     */
    public function validateEmail(string $email = '')
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $getArray = explode("@", $email);
        if (empty($email)) {
            $this->addError(__('Please enter your E-Mail-Address'));
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError(__('E-Mail-Address is invalid'));
        } else if (strlen($email) > 255) {
            $this->addError(__('E-Mail-Address have to many signs'));
        } else if (!checkdnsrr($getArray[1])) {
            $this->addError(__('E-Mail-Address not exists in web'));
        }
    }

    /**
     * 
     * @param string $message
     */
    public function validateMessage(string $message = '')
    {
        if (empty($message) && $message != "") {
            $this->addError(__('Please enter a message'));
        } else if (strlen($message) < 100) {
            $this->addError(__('Please type more then 100 signs'));
        }
    }

}