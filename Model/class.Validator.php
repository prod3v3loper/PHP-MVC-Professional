<?php

namespace Model;

/**
 * Description of Validator
 * 
 * This class hold the validate helpers for the validators.
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Validator extends ValidatorAbstract
{
    /**
     * Hold the errors for validation and more classes
     * 
     * @var array $errors
     */
    protected $errors = array();

    /**
     * Hold the successes for the validator and more classes
     * 
     * @var array $successes
     */
    protected $successes = array();

    /**
     * This function set validate for fields and call the validate function
     * 
     * @uses $contact->validateByArray($array);
     * 
     * @param array $data
     */
    public function validateByArray(array $data = [])
    {
        if ($data) {
            foreach ($data as $key => $val) {
                // Create method in validator
                $validate = 'validate' . ucfirst($key);
                // If this method exists ?
                if (method_exists($this, $validate)) {
                    /**
                     * On exists method in class validate input with the validator
                     * Call in UserValidator.php, class.ContactValidator.php etc.
                     */
                    $this->$validate($val);
                }
            }
        }
    }

    /**
     * Filter with regex
     * 
     * @param string $value - The value you want to filter with the regex
     * @param string $regex - E.g. /[a-z]/i
     * 
     * @return boolean
     */
    protected function filterRegex(string $value, string $regex)
    {
        return filter_var($value, FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regex)
        ));
    }

    /**
     * This function add the success messages
     * 
     * @param string $success
     */
    public function addSuccess(string $success)
    {
        if ($success) {
            $this->successes[] = $success;
        }
    }

    /**
     * This function returns the success messages
     * 
     * @return array
     */
    public function getSuccess()
    {
        return $this->successes;
    }

    /**
     * This function add the error messages
     * 
     * @param string $error - The error message you want to set
     * @param string $key - If you want you can use a key to specify messages
     */
    public function addError(string $error = '', string $key = '')
    {
        if ($error && $key) {
            $this->errors[$key][] = $error;
        } else if ($error && !$key) {
            $this->errors[] = $error;
        }
    }

    /**
     * This function returns the error messages
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * This function checks if errors array empty
     * Is empty returns TRUE if not empty return FALSE
     * 
     * @return boolean
     */
    public function isValid()
    {
        return empty($this->errors);
    }

}