<?php
namespace StoreCore\Admin;

class Configurator
{
    /**
     * @var array $DefaultSettings
     *     Default settings from the global config.ini configuration file.
     */
    private $DefaultSettings = array(
        'STORECORE_KILL_SWITCH' => '',
        'STORECORE_MAINTENANCE_MODE' => '',
        'STORECORE_STATISTICS' => 1,
        'STORECORE_NULL_LOGGER' => '',

        'STORECORE_DATABASE_DRIVER' => 'mysql',
        'STORECORE_DATABASE_DEFAULT_HOST' => 'localhost',
        'STORECORE_DATABASE_DEFAULT_DATABASE' => 'test',
        'STORECORE_DATABASE_USERNAME' => 'root',
        'STORECORE_DATABASE_PASSWORD' => '',
    );

    /**
     * @var array $IgnoredSettings
     *     Settings that MAY be set manually in the config.ini configuration
     *     file and settings that SHOULD NOT be overwritten by config.php.
     */
    private $IgnoredSettings = array(
        'STORECORE_FILESYSTEM_CACHE' => true,
        'STORECORE_FILESYSTEM_LIBRARY_ROOT' => true,
        'STORECORE_FILESYSTEM_LOGS' => true,
        'STORECORE_FILESYSTEM_STOREFRONT_ROOT' => true,

        'STORECORE_VERSION' => true,
        'STORECORE_MAJOR_VERSION' => true,
        'STORECORE_MINOR_VERSION' => true,
        'STORECORE_PATCH_VERSION' => true,
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
        $defined_constants = get_defined_constants(true);
        if (array_key_exists('user', $defined_constants)) {
            $defined_constants = $defined_constants['user'];
            foreach ($defined_constants as $name => $value) {
                $name = strtoupper($name);
                if (
                    strpos($name, 'STORECORE_', 0) === 0
                    && strpos($name, 'STORECORE_I18N_', 0) !== 0
                ) {
                    if (
                        array_key_exists($name, $this->DefaultSettings) === false
                        || $this->DefaultSettings[$name] !== $value
                    ) {
                        $this->set($name, $value);
                    }
                }
            }
        }
    }

    /**
     * @uses \StoreCore\Admin\Configurator::set()
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param void
     * @return bool
     */
    public function save()
    {
        $file = '<?php' . "\n";
        foreach ($this->Settings as $name => $value)
        {
            if (is_numeric($value)) {
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

        $return = file_put_contents(STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'config.php', $file, LOCK_EX);
        if ($return === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set($name, $value)
    {
        $name = strtoupper($name);
        if (!array_key_exists($name, $this->IgnoredSettings)) {
            $this->Settings[$name] = $value;
        }
    }
}
