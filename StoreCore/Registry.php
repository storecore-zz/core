<?php
namespace StoreCore;

use \Psr\Container\ContainerInterface as ContainerInterface;
use \Psr\Container\NotFoundException as NotFoundException;

/**
 * Global Registry Singleton
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
final class Registry implements SingletonInterface, ContainerInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer)
     */
    const VERSION = '1.0.0';

    /**
     * @var array $Data
     *   Data stored in the global registry.
     */ 
    private $Data = array();

    /**
     * @var object|null $Instance
     *   Single instance of the global registry or null if there is no instance yet.
     */
    private static $Instance = null;

    // Disable object instantiation and cloning
    private function __construct() {}
    private function __clone() {}

    /**
     * Get the single instance of the registry.
     *
     * @param void
     * @return self
     */
    public static function getInstance()
    {
        if (self::$Instance === null) {
            self::$Instance = new Registry();
        }
        return self::$Instance;
    }

    /**
     * Get a value from the global registry.
     *
     * @param string $id
     *   Unique identifier of the container element to fetch.
     * 
     * @return mixed
     *   Data currently stored in the registry.
     *
     * @throws \Psr\Container\NotFoundExceptionInterface
     *   No entry was found for the requested identifier.
     */
    public function get($id)
    {
        if ($this->has($id)) {
            return $this->Data[$id];
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * Check if something is stored in the registry.
     *
     * @param string $id
     *   Unique identifier of data possibly stored in the registry.
     * 
     * @return bool
     *   Returns true if the data identifier exists, otherwise false.
     */
    public function has($id)
    {
        return isset($this->Data[$id]);
    }

    /**
     * Set a shared value in the global registry.
     *
     * @param string $id
     *   Unique identifier of data to store in the registry.
     * 
     * @param mixed $value
     *   Global data to store in the registry.
     * 
     * @return void
     */
    public function set($id, $value)
    {
        $this->Data[$id] = $value;
    }
}
