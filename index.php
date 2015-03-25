<?php
/**
 * StoreCore Store Front Application
 *
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GPLv3
 * @version   0.1.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Load configuration
require 'version.php';
require 'config.php';
$configuration = parse_ini_file('config.ini', false);
foreach ($configuration as $name => $value) {
    $name = str_ireplace('.', '_', $name);
    $name = strtoupper($name);
    if (!defined($name)) {
        define($name, $value);
    }
}
unset($configuration, $name, $value);

// Bootstrap
if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT', __DIR__ . DIRECTORY_SEPARATOR . 'StoreCore' . DIRECTORY_SEPARATOR);
}
require STORECORE_FILESYSTEM_LIBRARY_ROOT . 'bootloader.php';

// Working directories
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

if (!defined('STORECORE_FILESYSTEM_LOGS')) {
    define('STORECORE_FILESYSTEM_LOGS', STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'logs' . DIRECTORY_SEPARATOR);
}

// Load and populate the global service locator
$registry = \StoreCore\Registry::getInstance();
$registry->set('Logger', new \StoreCore\FileSystem\Logger());
$registry->set('Request', new \StoreCore\Request());
$registry->set('Session', new \StoreCore\Session());
