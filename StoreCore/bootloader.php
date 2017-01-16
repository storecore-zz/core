<?php
/**
 * StoreCore Framework Bootloader
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0-beta.1
 */

// Global script/request timer start
if (empty($_SERVER['REQUEST_TIME_FLOAT'])) {
    $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
}

// Set the default character set to UTF-8.
ini_set('default_charset', 'UTF-8');

// Coordinated Universal Time (UTC)
date_default_timezone_set('UTC');

// Set the framework library root directory in case it was not set
// (for example, if the bootloader was included/required directly).
if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR);
}

// Load, instantiate, and register the StoreCore autoloader.
require __DIR__ . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader = new \StoreCore\Autoloader();
$loader->register();

// Link namespaces to directories.
$loader->addNamespace('Psr\Cache', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Cache');
$loader->addNamespace('Psr\Log', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Log');

$loader->addNamespace('StoreCore\Database', __DIR__ . DIRECTORY_SEPARATOR . 'Database', true);
$loader->addNamespace('StoreCore\FileSystem', __DIR__ . DIRECTORY_SEPARATOR . 'FileSystem', true);
$loader->addNamespace('StoreCore', __DIR__, true);

$loader->addNamespace('StoreCore\Admin', __DIR__ . DIRECTORY_SEPARATOR . 'Admin');
$loader->addNamespace('StoreCore\Modules', __DIR__ . DIRECTORY_SEPARATOR . 'Modules');
$loader->addNamespace('StoreCore\Types', __DIR__ . DIRECTORY_SEPARATOR . 'Types');

// Handle PHP errors as exceptions.
function exception_error_handler($errno, $errstr, $errfile, $errline) {
    $logger = new \StoreCore\FileSystem\Logger();
    $logger->debug($errstr . ' in ' . $errfile . ' on line ' . $errline);
    throw new \ErrorException($errstr, $errno, 1, $errfile, $errline);
}
set_error_handler('exception_error_handler', E_ALL | E_STRICT);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 0);

// Load core interfaces, abstract classes, and classes.
require __DIR__ . DIRECTORY_SEPARATOR . 'SingletonInterface.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Types' . DIRECTORY_SEPARATOR . 'TypeInterface.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Types' . DIRECTORY_SEPARATOR . 'ValidateInterface.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'ObserverInterface.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'SubjectInterface.php';

require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractController.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractModel.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'AbstractModel.php';

require __DIR__ . DIRECTORY_SEPARATOR . 'Registry.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Request.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Response.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Route.php';

// Load and populate the global service locator.
$registry = \StoreCore\Registry::getInstance();
$registry->set('Request', new \StoreCore\Request());

if (!defined('STORECORE_NULL_LOGGER')) {
    define('STORECORE_NULL_LOGGER', false);
}
if (STORECORE_NULL_LOGGER) {
    $registry->set('Logger', new \Psr\Log\NullLogger());
} else {
    $registry->set('Logger', new \StoreCore\FileSystem\Logger());
}
