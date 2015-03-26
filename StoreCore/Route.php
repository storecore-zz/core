<?php
namespace StoreCore;

class Route
{
    private $Controller;
    private $Path;

    public function __construct($path, $controller)
    {
        $this->setPath($path);
        $this->setController($controller);
    }

    private function setPath($path)
    {
        $path = '/' . ltrim($path, '/');
        $path = mb_strtolower($path, 'UTF-8');
        $this->Path = $path;
    }

    private function setController($controller)
    {
        $this->Controller = $controller;
    }
    
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
}
