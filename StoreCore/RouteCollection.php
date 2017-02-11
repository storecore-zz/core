<?php
namespace StoreCore;

/**
 * Collection of HMVC Routes
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class RouteCollection
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /** @var array $Routes */
    private $Routes = array();

    /**
     * Add a route to the collection.
     *
     * @param \StoreCore\Route $route
     * @return void
     */
    public function add(\StoreCore\Route $route)
    {
        $id = spl_object_hash($route);
        $this->Routes[$id] = $route;
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
        if ($this->isEmpty()) {
            return false;
        }
        foreach ($this->Routes as $route) {
            if ($route->getPath() == $path) {
                return true;
            }
        }
        return false;
    }
}
