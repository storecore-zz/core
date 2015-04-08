<?php
namespace StoreCore;

class RouteCollection implements \Countable
{
    /**
     * @type array $Routes
     */
    private $Routes = array();

    /**
     * Add a route to the collection.
     *
     * @param string $name
     * @param \StoreCore\Route $route
     */
    public function add($name, \StoreCore\Route $route)
    {
        $this->Routes[$name] = $route;
    }

    /**
     * Count the number of routes.
     *
     * @param void
     * @return int
     * @see http://php.net/manual/en/class.countable.php
     */
    public function count()
    {
        return count($this->Routes);
    }

    /**
     * Check if a path exists in the current route collection.
     *
     * @param void
     * @return bool
     */
    public function pathExists($path)
    {
        foreach ($this->Routes as $route) {
            if ($path == $route->getPath()) {
                return true;
            }
        }
        return false;
    }
}
