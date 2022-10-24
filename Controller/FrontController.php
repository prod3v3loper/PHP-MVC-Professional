<?php

namespace Controller;

use core\classes\secure\Mask,
    core\classes\lang\Lang;

/**
 * Description of FrontController
 *
 * @author      prod3v3loper
 * @copyright   (c) 2022, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class FrontController extends AbstractController
{
    const DEFAULT_CONTROLLER = "Controller\IndexController";

    const DEFAULT_ACTION = "indexAction";

    const ERROR_CONTROLLER = 'Controller\ErrorController';

    const ERROR_ACTION = 'error404Action';

    /**
     *
     * @var string $controller
     */
    private $controller = self::DEFAULT_CONTROLLER;

    /**
     *
     * @var string $action
     */
    private $action = self::DEFAULT_ACTION;

    /**
     *
     * @var string $basePath
     */
    private $basePath = '';

    /**
     *
     * @var array $params
     */
    protected $params = [];

    /**
     *
     * @var array $parts
     */
    protected $parts = [];

    /**
     * 
     * @param string $path
     */
    public function __construct(string $path = '')
    {
        $this->setBasePath($path);
    }

    /**
     * Returns the base path
     * 
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Returns the controller name
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the action name 
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the current Parameters
     * 
     * @return array
     */
    public function getParams()
    {
        return array_filter($this->params);
    }

    /**
     * Setter for the base path to root folder
     * 
     * @param string $basePath
     */
    private function setBasePath(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    /**
     * Check and set the controller (class)
     * 
     * @param string $controller
     */
    private function setController(string $controller = '')
    {
        if ($controller) {
            $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller)) . "Controller";
            if (class_exists($controller)) {
                $this->controller = $controller;
            } else {
                $this->controller = self::DEFAULT_CONTROLLER;
            }
        }
    }

    /**
     * Check and set the action (method) for the controller (class)
     * 
     * @param string $action
     */
    private function setAction(string $action = '')
    {
        if ($action) {
            $method = strtolower(strip_tags($action)) . "Action";
            $rc = new \ReflectionClass($this->controller);
            if ($rc->hasMethod($method)) {
                $this->action = $method;
            } else {
                $this->controller = self::ERROR_CONTROLLER;
                $this->action = self::ERROR_ACTION;
            }
        }
    }

    /**
     * Setter for parameters to use in controller (class) and action (method)
     * 
     * @param string $param - The parameter for the params array
     * @param string $part - The key for specific parts
     */
    protected function setParams(string $param = '', string $part = '')
    {
        if ($param && $part) {
            $this->params[$part][] = $param;
        } else if ($param && !$part) {
            $this->params[] = $param;
        }
    }

    /**
     * 
     * @param string $string
     * 
     * @return boolean
     */
    private function allowedSigns(string $string = '')
    {
        if (preg_match('/[a-z0-9\?\/\=\&]*$/i', $string)) {
            return true;
        }
        return false;
    }

    /**
     * Here we get and check the URL that was called by the user.
     * If there is no controller with a method that was called via the url, we can prevent this call from taking place
     * 
     * @see https://www.php.net/manual/en/function.filter-input.php
     */
    private function parseURL()
    {
        $path = trim(filter_input(INPUT_SERVER, "REQUEST_URI"), "/"); // Get URL

        if ($path && !$this->allowedSigns($path)) {
            $this->setController(self::ERROR_CONTROLLER);
            $this->setAction(self::ERROR_ACTION);
            return;
        }

        // Check whether the path in the basePath is at the beginning pos 0
        if ($this->getBasePath() && strpos($path, $this->getBasePath()) == 0) {
            $path = substr($path, strlen($this->getBasePath())); // Then cut off the domain
        }

        $this->parts = $path ? explode("/", $path) : []; // Split string 
        // Index in the url do not allow, we do not want to see this controller
        if (isset($this->parts[0]) && $this->parts[0] == "index") {
            header("Location: " . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR, true, 302);
        }

        if (isset($this->parts[0]) && $this->parts[0] == "de") {
            Lang::setLang("de");
            array_splice($this->parts, 0, 1);
        } else {
            Lang::setLang("en");
        }

        if (count($this->parts) < 5) {
            for ($i = 0; $i < count($this->parts); $i++) {
                if ($this->parts[$i] && $i == 0 && count($this->parts) == 1) {
                    $this->setController($this->parts[$i]); // Set controller
                    $this->setAction($this->parts[$i]); // Set action
                } else if ($this->parts[$i] && $i == 0 && count($this->parts) == 2) {
                    $this->setController($this->parts[$i]); // Set controller
                } else if ($this->parts[$i] && $i == 1 && count($this->parts) == 2) {
                    $this->setAction($this->parts[$i]); // Set action
                } else if ($this->parts[$i]) {
                    $this->setParams($this->parts[$i]); // Set parameters
                }
            }
        }
    }

    /**
     * Run controller (class) with action (method) and the parameters
     * 
     * @see https://www.php.net/manual/en/function.call-user-func-array.php
     */
    public function run()
    {
        $this->parseURL();
        call_user_func_array(array(new $this->controller, $this->action), array($this->params));
    }

}