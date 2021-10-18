<?php

namespace Modal;

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
     * @var type 
     */
    protected $errors = array();

    /**
     * Hold the successes for the validator and more classes
     * @var type 
     */
    protected $successes = array();

    /**
     * This function set validate for POST fields and call the validate function
     */
    public function validateByArray(array $data)
    {

        if ($data) {
            foreach ($data as $key => $val) {

                $validate = 'validate' . ucfirst($key);
                //                _evd($validate);
                /**
                 * Check if method exists in this classes
                 * @see http://php.net/manual/en/function.method-exists.php
                 */
                if (method_exists($this, $validate)) {
                    $this->$validate($val);
                }
            }
        }
    }

    /**
     * Filter with regex
     * @param type $value
     * @param type $regex
     * @return type
     */
    protected function filterRegex($value, $regex)
    {

        return filter_var($value, FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regex)
        ));
    }

    /**
     * This function add the success messages
     * @param type
     */
    public function addSuccess($success)
    {

        $this->successes[] = $success;
    }

    /**
     * This function returns the success messages
     * @return type
     */
    public function getSuccess()
    {

        return $this->successes;
    }

    /**
     * This function add the error messages
     * @param type
     */
    public function addError($error, $key = '')
    {
        if ($key) {
            $this->errors[$key][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    /**
     * This function returns the error messages
     * @return array
     */
    public function getErrors()
    {

        return $this->errors;
    }

    /**
     * This function checks if errors
     * Is empty returns TRUE if not empty return FALSE
     * @return type
     */
    public function isValid()
    {

        return empty($this->errors);
    }
}
