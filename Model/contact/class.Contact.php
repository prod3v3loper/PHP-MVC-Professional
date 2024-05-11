<?php

namespace Model\contact;

use core\classes\http\Filter as F,
    core\classes\secure\Mask as M;

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

    // SEPCIAL Methods //////////////////////////////////////////////////////////

    public function save()
    {
        return parent::saveObject($this);
    }

    // SETTER Methods /////////////////////////////////////////////////////////

    public function setName(string $name)
    {
        // Sanitize and mask example string
        $name = F::sanitizeSTR($name);
        $name = M::encode($name, true);

        $this->name = $name;
    }

    public function setEmail(string $email)
    {
        // Sanitize and mask example for email
        $email = F::sanitizeEmail($email);
        $email = M::encode($email, true);

        $this->email = $email;
    }

    public function setSubject(string $subject)
    {
        $subject = F::sanitizeSTR($subject);
        $subject = M::encode($subject, true);

        $this->subject = $subject;
    }

    public function setMessage(string $message)
    {
        $message = F::sanitizeSTR($message);
        $message = M::encode($message, true);

        $this->message = $message;
    }

    public function setCreated(int $created)
    {
        // Sanitize and mask example for integer
        $created = F::sanitizeINT($created);
        $created = M::encode($created, true);

        $this->created = $created;
    }

    // GETTER Methods /////////////////////////////////////////////////////////

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
