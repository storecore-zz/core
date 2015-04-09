<?php
namespace StoreCore;

class Route
{
    /**
     * @type string      $Controller
     * @type null|string $Method
     * @type null|array  $Parameters
     * @type string      $Path
     */
    private $Controller;
    private $Method;
    private $Parameters;
    private $Path;

    /**
     * @param string $path
     * @param string $controller
     * @return void
     */
    public function __construct($path, $controller, $method = null, $parameters = null)
    {
        $this->setPath($path);
        $this->setController($controller);

        if ($method !== null) {
            $this->setMethod($method);
            if ($parameters !== null) {
                $this->setParameters($parameters);
            }
        }
    }

    /**
     * @param void
     * @return void
     */
    public function dispatch()
    {
        $controller = $this->Controller;
        if (is_subclass_of($controller, '\StoreCore\AbstractController')) {
            $registry = \StoreCore\Registry::getInstance();
            $thread = new $controller($registry);
        } else {
            $thread = new $controller();
        }
    }

    /**
     * @param void
     * @return string
     */
    public function getPath()
    {
        return $this->Path;
    }

    /**
     * @param string $controller
     * @return void
     */
    private function setController($controller)
    {
        $this->Controller = $controller;
    }

    /**
     * @param string $method
     * @return void
     */
    private function setMethod($method)
    {
        $this->Method = $method;
    }

    /**
     * @param array $method
     * @return void
     */
    private function setParameters(array $parameters)
    {
        $this->Parameters = $parameters;
    }
    
    /**
     * @param string $path
     * @return void
     */
    private function setPath($path)
    {
        $path = '/' . ltrim($path, '/');
        $path = mb_strtolower($path, 'UTF-8');
        $this->Path = $path;
    }
}
