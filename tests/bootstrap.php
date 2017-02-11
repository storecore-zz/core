<?php
/**
 * Bootstrap for PHPUnit
 *
 * @version 0.1.0
 */
 
// Load configuration
require realpath(__DIR__ . '/../version.php');
require realpath(__DIR__ . '/../config.php');

// Define global file system constants
define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', realpath(__DIR__ . '/../StoreCore') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_CACHE_DIR', realpath(__DIR__ . '/../cache') . DIRECTORY_SEPARATOR);
define('STORECORE_FILESYSTEM_LOGS_DIR', realpath(__DIR__ . '/../logs') . DIRECTORY_SEPARATOR);

// Load the StoreCore bootstrap and autoloader
require realpath(__DIR__ . '/../StoreCore/bootloader.php');
