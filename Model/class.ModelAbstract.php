<?php

namespace Model;

/**
 * Description of Modal Abstract
 * 
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class ModelAbstract
{
    /**
     * ID placeholder for all modals
     * 
     * @var integer $ID
     */
    protected $ID = 0;

    /**
     * Returns the ID back
     * 
     * @return integer
     */
    public function getID()
    {
        return (int) $this->ID;
    }

    /**
     * Settter for the ID
     * 
     * @param integer|null $ID
     */
    public function setID($ID = NULL)
    {
        $this->ID = (int) $ID;
    }

    /**
     * This function set array to objects from object
     * 
     * @see http://php.net/manual/en/function.method-exists.php
     * 
     * @param array $array
     */
    public function setByArray(array $array = [])
    {
        if ($array) {
            foreach ($array as $key => $value) {
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
    }
}
