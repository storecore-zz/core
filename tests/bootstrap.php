<?php
/**
 * Bootstrap for PHPUnit
 *
 * @version 0.1.0
 */

// Load configuration
require realpath(__DIR__ . '/../version.php');
require realpath(__DIR__ . '/../config.php');
$configuration = parse_ini_file(realpath(__DIR__ . '/../config.ini'), false);
foreach ($configuration as $name => $value) {
    $name = str_ireplace('.', '_', $name);
    $name = strtoupper($name);
    if (!defined($name)) {
        define($name, $value);
    }
}
unset($configuration, $name, $value);

// Define global file system constants
define('STORECORE_FILESYSTEM_LIBRARY_ROOT', realpath(__DIR__ . '/../StoreCore') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_CACHE', realpath(__DIR__ . '/../cache') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_LOGS', realpath(__DIR__ . '/../logs') . DIRECTORY_SEPARATOR);

// Load the StoreCore bootstrap and autoloader
require realpath(__DIR__ . '/../StoreCore/bootloader.php');
