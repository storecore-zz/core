<?php
namespace StoreCore;

/**
 * Global Registry Singleton
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
final class Registry implements SingletonInterface
{
    const VERSION = '0.1.0';

    /**
     * @var array $Data
     * @var object|null $Instance
     */
    private $Data = array();
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
     * Set a shared value in the global registry.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->Data[$key] = $value;
    }

    /**
     * Get a value from the registry.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        return (isset($this->Data[$key]) ? $this->Data[$key] : null);
    }

    /**
     * Check if something is stored in the registry.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->Data[$key]);
    }
}
