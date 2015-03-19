<?php
/**
 * StoreCore Store Front Application
 *
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GPLv3
 * @version   0.1.0
 */
 
// Load configuration
require_once 'version.php';

if (is_file('config.php')) {
    require 'config.php';
} else {
    $configuration = parse_ini_file('config.ini', false);
    foreach ($configuration as $name => $value) {
        $name = str_ireplace('.', '_', $name);
        $name = strtoupper($name);
        define($name, $value);
    }
    unset($configuration, $name, $value);
}

if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT', __DIR__ . DIRECTORY_SEPARATOR . 'StoreCore');
}
require rtrim(STORECORE_FILESYSTEM_LIBRARY_ROOT, '\\/') . DIRECTORY_SEPARATOR . 'bootloader.php';
