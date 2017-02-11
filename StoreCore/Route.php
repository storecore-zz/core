<?php
namespace StoreCore;

/**
 * HMVC Route
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class Route
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * @var string      $Controller
     * @var null|string $Method
     * @var null|array  $Parameters
     * @var string      $Path
     */
    private $Controller;
    private $Method;
    private $Parameters;
    private $Path;

    /**
     * @param string $path
     * @param string $controller
     * @param string|null $method
     * @param mixed|null $parameters
     * @return self
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
     * Instantiate a controller and optionally call a method.
     *
     * @param void
     * @return void
     */
    public function dispatch()
    {
        $controller = $this->Controller;
        if (is_subclass_of($controller, '\StoreCore\AbstractController')) {
            $thread = new $controller(\StoreCore\Registry::getInstance());
        } else {
            $thread = new $controller();
        }

        if ($this->Method !== null) {
            $method = $this->Method;
            if ($this->Parameters !== null) {
                $thread->$method($this->Parameters);
            } else {
                $thread->$method();
            }
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
     * @param mixed $parameters
     * @return void
     */
    private function setParameters($parameters)
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
