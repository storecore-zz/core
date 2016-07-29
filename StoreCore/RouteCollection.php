<?php
namespace StoreCore;

/**
 * Collection of HMVC Routes
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class RouteCollection implements \Countable
{
    const VERSION = '0.1.0';

    /** @type array $Routes */
    private $Routes = array();

    /**
     * Add a route to the collection.
     *
     * @param \StoreCore\Route $route
     * @return void
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
     * Call all routes.
     *
     * @param void
     * @return void
     */
    public function dispatch()
    {
        if ($this->isEmpty()) {
            return;
        }

        $routes = $this->Routes;
        foreach ($routes as $route) {
            $route->dispatch();
        }
    }

    /**
     * Checks whether the route collection is empty.
     *
     * @param void
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->Routes);
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
