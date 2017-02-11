<?php
namespace StoreCore\Database;

use \StoreCore\Route as Route;
use \StoreCore\RouteCollection as RouteCollection;

/**
 * Route Factory
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class RouteFactory extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Find a route or route collection that matches a request path.
     *
     * @param string|null $path
     *   Optional path routed to a controller in the '/path/to/contoller/'
     *   format.  If the path is not set, the current HTTP request path is
     *   used.
     *
     * @return \StoreCore\Route|\StoreCore\RouteCollection|null
     *   Returns a Route object on a single match, a RouteCollection object on
     *   multiple matching routes, or null if no matching route path was found.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the $path parameter is
     *   not a string.
     *
     * @uses \StoreCore\Request::getRequestPath()
     */
    public function find($path = null)
    {
        if ($path === null) {
            $path = $this->Request->getRequestPath();
        } elseif (!is_string($path)) {
            throw new \InvalidArgumentException();
        }

        /*
              SELECT route_controller, controller_method, method_parameters
                FROM sc_routes
               WHERE route_path = :route_path
            ORDER BY dispatch_order ASC
         */
        try {
            $stmt = $this->Connection->prepare('SELECT route_controller, controller_method, method_parameters FROM sc_routes WHERE route_path = :route_path ORDER BY dispatch_order ASC');
            $stmt->bindParam(':route_path', $path, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt = null;
        } catch (\PDOException $e) {
            return null;
        }

        if (empty($result)) {
            return null;
        }

        if (count($result) == 1) {
            $result = $result[0];
            if ($result['method_parameters'] !== null) {
                $result['method_parameters'] = json_decode($result['method_parameters'], true);
            }
            return new Route($path, $result['route_controller'], $result['controller_method'], $result['method_parameters']);
        } else {
            $routes = new RouteCollection();
            foreach ($result as $row) {
                if ($row['method_parameters'] !== null) {
                    $row['method_parameters'] = json_decode($row['method_parameters'], true);
                }
                $route = new Route($path, $row['route_controller'], $row['controller_method'], $row['method_parameters']);
                $routes->add($route);
            }
            return $routes;
        }
    }

    /**
     * Find a route collection that matches parts of a path.
     *
     * @param string $path
     * @return \StoreCore\RouteCollection|null
     * @throws \InvalidArgumentException
     */
    public function findRouteCollection($path)
    {
        if (!is_string($path) || empty($path)) {
            throw new \InvalidArgumentException();
        }
        $path = str_ireplace('%', null, $path);
        $path = trim($path, '/');
        $path = '/' . $path . '/%';

        /*
              SELECT route_path, route_controller, controller_method, method_parameters
                FROM sc_routes
               WHERE route_path LIKE :route_path
            ORDER BY dispatch_order ASC
         */
        $stmt = $this->Connection->prepare('SELECT route_path, route_controller, controller_method, method_parameters FROM sc_routes WHERE route_path LIKE :route_path ORDER BY dispatch_order ASC');
        $stmt->bindParam(':route_path', $path, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt = null;

        if (empty($result)) {
            return null;
        }

        $routes = new RouteCollection();
        foreach ($result as $row) {
            if ($row['method_parameters'] !== null) {
                $row['method_parameters'] = json_decode($row['method_parameters'], true);
            }
            $route = new Route($row['route_path'], $row['route_controller'], $row['controller_method'], $row['method_parameters']);
            $routes->add($route);
        }
        return $routes;
    }
}
