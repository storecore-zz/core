<?php
namespace StoreCore\Admin;

class Configurator
{
    /**
     * @var array $DefaultSettings
     *     Default settings from the global config.ini configuration file.
     */
    private $DefaultSettings = array(
        'STORECORE_KILL_SWITCH' => false,
        'STORECORE_MAINTENANCE_MODE' => false,
        'STORECORE_STATISTICS' => true,
        'STORECORE_NULL_LOGGER' => false,

        'STORECORE_DATABASE_DRIVER' => 'mysql',
        'STORECORE_DATABASE_DEFAULT_HOST' => 'localhost',
        'STORECORE_DATABASE_DEFAULT_DATABASE' => 'test',
        'STORECORE_DATABASE_USERNAME' => 'root',
        'STORECORE_DATABASE_PASSWORD' => '',
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
                if (strpos($defined_constants, 'STORECORE_', 0) === 0) {
                    $this->set($name, $value);
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
        $file = '<?php' . PHP_EOL;
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
                $file .= "define('{$name}', '{$value}');";
            }
            $file .= PHP_EOL;
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
        $this->Settings[$name] = $value;
    }
}
