<?php

namespace Modal;

/**
 * Description of Modal Abstract
 * 
 * @author      Samet Tarim
 * @copyright   (c) 2019, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class ModalAbstract {

    /**
     * ID placeholder for all modals
     * @var type 
     */
    protected $ID = 0;

    // GETTER //////////////////////////////////////////////////////////////////

    /**
     * Return the ID back
     * @return type
     */
    public function getID() {

        return (int) $this->ID;
    }

    // SETTER //////////////////////////////////////////////////////////////////

    /**
     * Set the ID
     * @param type
     */
    public function setID($ID = NULL) {

        $this->ID = (int) $ID;
    }

    /**
     * This function set array to objects from object
     * @param array
     */
    public function setByArray(array $array = array()) {

        if ($array) {
            foreach ($array as $key => $value) {
                $setter = 'set' . ucfirst($key);
//                _evd($setter);
                /**
                 * Check if method exists in this classes
                 * @see http://php.net/manual/en/function.method-exists.php
                 */
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
    }

}
