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
    public function add(\StoreCore\Route $route)
    {
        $this->Routes[$route->getPath()] = $route;
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
     * @param string $path
     * @return bool
     */
    public function pathExists($path)
    {
        return array_key_exists($path, $this->Routes);
    }
}
