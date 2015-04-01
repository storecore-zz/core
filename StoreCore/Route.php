<?php
namespace StoreCore;

class Route
{
    private $Controller;
    private $Path;

    /**
     * @param string $path
     * @param string $controller
     * @return void
     */
    public function __construct($path, $controller)
    {
        $this->setPath($path);
        $this->setController($controller);
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
