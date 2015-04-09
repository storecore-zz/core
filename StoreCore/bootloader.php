<?php
/**
 * StoreCore Framework Bootloader
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GPLv3
 * @version   0.1.0
 */

// Coordinated Universal Time (UTC)
date_default_timezone_set('UTC');

// Load, instantiate, and register the StoreCore autoloader
require __DIR__ . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader = new \StoreCore\Autoloader();
$loader->register();

// Link namespaces to directories
$loader->addNamespace('Psr\Cache', __DIR__ . DIRECTORY_SEPARATOR . 'Psr/Cache');
$loader->addNamespace('Psr\Log', __DIR__ . DIRECTORY_SEPARATOR . 'Psr/Log');
$loader->addNamespace('StoreCore', __DIR__);
$loader->addNamespace('StoreCore\Admin', __DIR__ . DIRECTORY_SEPARATOR . 'Admin');
$loader->addNamespace('StoreCore\Database', __DIR__ . DIRECTORY_SEPARATOR . 'Database');
$loader->addNamespace('StoreCore\FileSystem', __DIR__ . DIRECTORY_SEPARATOR . 'FileSystem');
$loader->addNamespace('StoreCore\Types', __DIR__ . DIRECTORY_SEPARATOR . 'Types');

// Handle PHP errors as exceptions
function exception_error_handler($errno, $errstr, $errfile, $errline) {
    $logger = new \StoreCore\FileSystem\Logger();
    $logger->debug($errstr . ' in ' . $errfile . ' on line ' . $errline);
    throw new \ErrorException($errstr, $errno, 1, $errfile, $errline);
}
set_error_handler('exception_error_handler', E_ALL | E_STRICT);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 0);

// Load core interfaces, abstract classes, and classes
require __DIR__ . DIRECTORY_SEPARATOR . 'SingletonInterface.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Types' . DIRECTORY_SEPARATOR . 'TypeInterface.php';

require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractModel.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractController.php';

require __DIR__ . DIRECTORY_SEPARATOR . 'Registry.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Request.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Response.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Route.php';
