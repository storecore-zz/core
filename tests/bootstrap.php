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
define('\StoreCore\FileSystem\LIBRARY_ROOT_DIR', realpath(__DIR__ . '/../StoreCore') . DIRECTORY_SEPARATOR);
define('\StoreCore\FileSystem\STOREFRONT_ROOT_DIR', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
define('\StoreCore\FileSystem\CACHE_DIR', realpath(__DIR__ . '/../cache') . DIRECTORY_SEPARATOR);
define('\StoreCore\FileSystem\LOGS_DIR', realpath(__DIR__ . '/../logs') . DIRECTORY_SEPARATOR);

// Load the StoreCore bootstrap and autoloader
require realpath(__DIR__ . '/../StoreCore/bootloader.php');
