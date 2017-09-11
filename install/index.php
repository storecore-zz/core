<?php
/**
 * StoreCore Installer
 *
 * This installation application bypasses the main front controller, which
 * MAY fail due tu a missing or misconfigured database connection or some
 * missing configuration setting.  To allow for a command-line interface (CLI)
 * installation, initial file system checks will result in PHP escape code
 * `exit(1)` on errors.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
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

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load configuration files: require version.php and config.php.
if (is_file(realpath(__DIR__ . '/../version.php'))) {
    require_once realpath(__DIR__ . '/../version.php');
} else {
    echo 'StoreCore versioning file version.php not found.';
    exit(1);
}

if (is_file(realpath(__DIR__ . '/../config.php'))) {
    require_once realpath(__DIR__ . '/../config.php');
} else {
    echo 'StoreCore configuration file config.php not found.';
    exit(1);
}

// Boot the core: require bootloader.php from the library.
if (is_file(realpath(__DIR__ . '/../StoreCore/bootloader.php'))) {
    require_once realpath(__DIR__ . '/../StoreCore/bootloader.php');
} elseif (defined('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR') && is_file(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'bootloader.php')) {
    require_once STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'bootloader.php';
} else {
    echo 'StoreCore bootstrap file bootloader.php not found.';
    exit(1);
}

// Define undefined global constants.
if (!defined('STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR')) {
    define('STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
}

if (!defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
    if (is_dir(realpath(__DIR__ . '/../cache'))) {
        define('STORECORE_FILESYSTEM_CACHE_DIR', realpath(__DIR__ . '/../cache') . DIRECTORY_SEPARATOR);
    } else {
        echo 'StoreCore global cache directory /cache/ not found.';
        exit(1);
    }
}

if (!defined('STORECORE_FILESYSTEM_LOGS_DIR')) {
    if (is_dir(realpath(__DIR__ . '/../logs'))) {
        define('STORECORE_FILESYSTEM_LOGS_DIR', realpath(__DIR__ . '/../logs') . DIRECTORY_SEPARATOR);
    } else {
        echo 'StoreCore logging directory /logs/ not found.';
        exit(1);
    }
}

// Load a language pack if not in CLI mode.
if (php_sapi_name() !== 'cli') {
    if (!defined('STORECORE_FILESYSTEM_CACHE_DATA_DIR')) {
        if (is_dir(realpath(STORECORE_FILESYSTEM_CACHE_DIR . 'data'))) {
            define('STORECORE_FILESYSTEM_CACHE_DATA_DIR', STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR);
        } else {
            echo 'StoreCore data cache directory /cache/data/ not found.';
            exit(1);
        }
    }
    \StoreCore\I18N\Locale::load();
}

// Run the installer through the administration front controller’s
// `install()` method as a single point of entry.
$route = new \StoreCore\Route('/install/', '\StoreCore\Admin\FrontController');
$route->dispatch();
