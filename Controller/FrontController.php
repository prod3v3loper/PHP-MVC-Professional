<?php

namespace Controller;

/**
 * Description of FrontController
 * 
 * Simple FrontController
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class FrontController extends ErrorController
{

    // Defaults, if not specified
    const DEFAULT_CONTROLLER = "Controller\IndexController";
    const DEFAULT_ACTION = "indexAction";

    /**
     *
     * @var String
     */
    private $controller = self::DEFAULT_CONTROLLER;

    /**
     *
     * @var String
     */
    private $action = self::DEFAULT_ACTION;

    /**
     *
     * @var String
     */
    private $basePath = "";

    /**
     *
     * @var Array
     */
    protected $params = array();

    /**
     *
     * @var Array
     */
    protected $parts = array();

    /**
     *
     * @var Integer
     */
    protected $partsCount = 0;

    /**
     * 
     * @param String $path
     */
    public function __construct($path = '')
    {
        $this->basePath = $path;
        $this->parseURL();
    }

    /**
     * Here we get and check the URL that was called by the user.
     * If there is no controller with a method that was called via the url, we can prevent this call from taking place
     */
    private function parseURL()
    {
        // Get URL
        $path = trim(filter_input(INPUT_SERVER, "REQUEST_URI"), "/");

        // Check whether the path in the basePath is at the beginning pos 0
        if ($this->basePath && strpos($path, $this->basePath) == 0) {
            // Then cut off the domain
            $path = substr($path, strlen($this->basePath));
        }

        // Split url
        $part = explode("/", $path);
        $this->parts = $part;
        $this->partsCount = count($part);

        // Index in the url do not allow, we do not want to see this controller.
        if ($part[0] == "index") {
            header("Location: " . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR);
        }

        // Loop parsed Query
        for ($i = 0; $i < $this->partsCount; $i++) {
            // Only for the index path
            if ($part[$i] && $i == 0 && count($part) == 1) {
                $this->setController($part[$i]); // Set controller
                $this->setAction($part[$i]); // Set action
            } else if ($part[$i] && $i == 0 && count($part) == 2) {
                $this->setController($part[$i]); // Set controller
            } else if ($part[$i] && $i == 1 && count($part) == 2) {
                $this->setAction($part[$i]); // Set action
            } else if ($part[$i]) {
                $this->setParams($part[$i]); // Set parameters
            }
        }
    }

    /**
     * 
     * @return String
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * 
     * @return String
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the current Params
     * @return Array
     */
    public function getParams()
    {
        return array_filter($this->params);
    }

    /**
     * 
     * @return String
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Check and set the Controller class
     * 
     * @param String $controller
     */
    private function setController($controller)
    {
        // Create controller
        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller)) . "Controller";
        // Does this class exist
        if (class_exists($controller)) {
            $this->controller = $controller;
        } else {
            $this->controller = self::DEFAULT_CONTROLLER;
        }
    }

    /**
     * Check and set the Action for the class Method
     * 
     * @param String $action
     */
    private function setAction($action)
    {
        // Create action method
        $method = strtolower($action) . "Action";
        // Classes runner
        $rc = new \ReflectionClass($this->controller);
        // Does this class also have this method ?
        if ($rc->hasMethod($method)) {
            $this->action = $method;
        } else {
            $this->controller = self::ERROR_CONTROLLER;
            $this->action = self::ERROR_ACTION;
        }
    }

    /**
     * Set params for controller class and action method
     * 
     * @param String $params
     * @param String $part
     */
    protected function setParams($params, $part = '')
    {
        if ($part) {
            $this->params[$part][] = $params;
        } else {
            $this->params[] = $params;
        }
    }

    /**
     * 
     * @param String $basePath
     */
    private function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Run class with method and params
     */
    public function run()
    {

        //        var_dump($this->controller);
        //        var_dump($this->action);
        //        var_dump($this->partsCount);
        //        var_dump($this->params);
        call_user_func_array(array(new $this->controller, $this->action), array($this->params));
    }
}
