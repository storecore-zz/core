<?php
namespace StoreCore\Admin;

/**
 * Configurator
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2014-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Configurator
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var array $IgnoredSettings
     *   Settings that MUST be set manually in the config.php configuration
     *   file and settings that SHOULD NOT be defined by config.php.  For
     *   example, the four version constants are defined in version.php, so
     *   these cannot be defined in config.php.
     */
    private $IgnoredSettings = array(
        'STORECORE_VERSION'       => true,
        'STORECORE_MAJOR_VERSION' => true,
        'STORECORE_MINOR_VERSION' => true,
        'STORECORE_PATCH_VERSION' => true,

        'STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR' => true,
    );

    /**
     * @var array $Settings
     */
    private $Settings = array();

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        foreach ($this->IgnoredSettings as $name => $value) {
            if ($value === false) {
                unset($this->IgnoredSettings[$name]);
            }
        }

        /*
         * Parse user-defined constants and ignore constants
         * included in $this->IgnoredSettings.
         */
        $defined_constants = get_defined_constants(true);
        if (array_key_exists('user', $defined_constants)) {
            $defined_constants = $defined_constants['user'];
            foreach ($defined_constants as $name => $value) {
                if (!array_key_exists($name, $this->IgnoredSettings)) {
                    /*
                     * Only save constants with the STORECORE_ prefix or
                     * constants from a \StoreCore namespace, but ignore all
                     * language string constants from the \StoreCore\I18N namespace.
                     */
                    if (
                        strpos($name, 'STORECORE_', 0) === 0
                        || (strpos($name, 'StoreCore\\', 0) === 0 && strpos($name, 'StoreCore\\I18N\\', 0) !== 0)
                    ) {
                        $this->Settings[$name] = $value;
                    }
                }
            }
        }
    }

    /**
     * Save the config.php configuration file.
     *
     * @param void
     * @return bool
     */
    public function save()
    {
        $file = '<?php' . "\n";
        foreach ($this->Settings as $name => $value) {
            /*
             * Namespace constants like \Foo\BAR_BAZ with a trailing backslash
             * must be defined without the trailing backslash in a PHP define:
             * define('Foo\\BAR_BAZ', 1).
             */
            $name = ltrim($name, '\\');
            $name = str_ireplace('\\', '\\\\', $name);

            if ($value === true) {
                $file .= "define('{$name}', true);";
            } elseif ($value === false) {
                $file .= "define('{$name}', false);";
            } elseif (is_numeric($value)) {
                $file .= "define('{$name}', {$value});";
            } else {
                if (is_array($value)) {
                    $value = json_encode($value);
                } elseif (is_object($value)) {
                    $value = serialize($value);
                }
                $value = str_ireplace('\\', '\\\\', $value);
                $file .= "define('{$name}', '{$value}');";
            }
            $file .= "\n";
        }

        // Save config.php in the root or its parent directory.
        $filename = STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'config.php';
        $return = file_put_contents($filename, $file, LOCK_EX);
        if ($return === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Set a setting as a name/value pair.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     *
     * @throws \InvalidArgumentException
     *   An SPL (Standard PHP Library) invalid argument logic exception is
     *   thrown if the first parameter is not a string or an empty string.  The
     *   value in the second parameter is not checked and stored "as is."
     */
    public function set($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException();
        }

        $name = trim($name);
        if (empty($name)) {
            throw new \InvalidArgumentException();
        }

        // Replace spaces and hyphens by underscores.
        $name = str_replace(' ', '_', $name);
        $name = str_replace('-', '_', $name);
        // Replace multiple underscores by a single underscore.
        $name = preg_replace('/_{1,}/', '_', $name);
        // Strip a leading or trailing underscore.
        $name = trim($name, '_');
        // Change to uppercase for proper constant naming.
        $name = strtoupper($name);

        if (!array_key_exists($name, $this->IgnoredSettings)) {
            $this->Settings[$name] = $value;
        }
    }

    /**
     * Write a single setting to the config.php configuration file.
     *
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public static function write($name, $value)
    {
        $writer = new \StoreCore\Admin\Configurator();
        $writer->set($name, $value);
        return $writer->save();
    }
}
