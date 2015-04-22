<?php
namespace StoreCore;

/**
 * Configuration Loader and Reader
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Config
{
    /** @var string VERSION */
    const VERSION = '0.1.0';

    /** @var array $DefinedConstants */
    protected static $DefinedConstants = array();

    /** @var object|null $Instance */
    private static $Instance = null;

    /** Disable object instantiation */
    private function __construct() {}

    /** Disable object cloning */
    private function __clone() {}

    /**
     * Get defined constants.
     *
     * @param string|null $namespace
     *
     * @return array|null
     */
    public static function getDefinedConstants($namespace = null)
    {
        if ($namespace === null) {
            return static::$DefinedConstants;
        } else {
            $namespace = '\\' . ltrim($namespace, '\\');
            if (array_key_exists($namespace, static::$DefinedConstants)) {
                return static::$DefinedConstants[$namespace];
            } else {
                return null;
            }
        }
    }

    /**
     * Get a single instance of the current configuration.
     *
     * @param void
     * @return self
     */
    public static function getInstance()
    {
        if (self::$Instance === null) {
            self::$Instance = new Config();
        }
        return self::$Instance;
    }

    /**
     * Parse a .ini configuration file.
     *
     * @param string $filename;
     * @return void
     */
    public static function parse($filename = 'config.ini')
    {
        $settings = parse_ini_file($filename, false);

        foreach ($settings as $name => $value) {

            $name = explode('.', $name, 2);

            $namespace = explode('_', $name[0]);
            $namespace[0] = str_replace('storecore', 'StoreCore', $namespace[0]);
            if (array_key_exists(1, $namespace)) {
                $namespace[1] = ucfirst(strtolower($namespace[1]));
            }
            $namespace = implode('\\', $namespace);

            $name = $namespace . '\\' . strtoupper($name[1]);

            if (!defined($name)) {
                define($name, $value);
                static::$DefinedConstants[$namespace][$name] = $value;
            }
        }
    }
}
