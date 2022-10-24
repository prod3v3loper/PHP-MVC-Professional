<?php

namespace Model\contact;

use core\classes\secure\Mask;

/**
 * Description of Contact
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Contact extends ContactModel
{
    /**
     * @var string $name
     */
    protected $name = '';

    /**
     * @var string $email
     */
    protected $email = '';

    /**
     * @var string $subject
     */
    protected $subject = '';

    /**
     * @var string $message
     */
    protected $message = '';

    /**
     * @var integer $created
     */
    protected $created = 0;

    /**
     * 
     * @param string $name
     */
    public function setName(string $name = '')
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string $email
     */
    public function setEmail(string $email = '')
    {
        // Extra check if needed
        if (is_string($email) && strlen($email) > 0 && strlen($email) <= 255) {
            // Mask here input
            $this->email = Mask::encode($email, true);
        }
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCreated()
    {
        return $this->created;
    }

}