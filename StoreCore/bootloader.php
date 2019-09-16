<?php
/**
 * StoreCore Framework Bootloader
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
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

// Multibyte uppercase first character
if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str)
    {
        $str = explode(' ', $str, 2);
        $str[0] = mb_convert_case($str[0], MB_CASE_TITLE, 'UTF-8');
        $str = implode(' ', $str);
        return $str;
    }
}

// Strip slashes on GPC arrays.
// @see https://www.php.net/manual/en/function.stripslashes.php
if (!function_exists('stripslashes_deep')) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
        return $value;
    }
}

if (
    (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase')) != 'off'))
) {
    $_GET = stripslashes_deep($_GET);
    $_POST = stripslashes_deep($_POST);
    $_COOKIE = stripslashes_deep($_COOKIE);
}

// Set the framework library root directory in case it was not set
// (for example, if the bootloader was included/required directly).
if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR);
}

// Load and instantiate the StoreCore autoloader.
require __DIR__ . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader = new \StoreCore\Autoloader();

// Link namespaces to directories.
$loader->addNamespace('Psr\Cache', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Cache');
$loader->addNamespace('Psr\Container', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Container');
$loader->addNamespace('Psr\EventDispatcher', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'EventDispatcher');
$loader->addNamespace('Psr\Http\Client', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Client');
$loader->addNamespace('Psr\Http\Message', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message');
$loader->addNamespace('Psr\Http\Server', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Server');
$loader->addNamespace('Psr\Link', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Link');
$loader->addNamespace('Psr\Log', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'Log');
$loader->addNamespace('Psr\SimpleCache', __DIR__ . DIRECTORY_SEPARATOR . 'Psr' . DIRECTORY_SEPARATOR . 'SimpleCache');

$loader->addNamespace('StoreCore\Database', __DIR__ . DIRECTORY_SEPARATOR . 'Database', true);
$loader->addNamespace('StoreCore\FileSystem', __DIR__ . DIRECTORY_SEPARATOR . 'FileSystem', true);

$loader->addNamespace('StoreCore\AMP', __DIR__ . DIRECTORY_SEPARATOR . 'AMP');
$loader->addNamespace('StoreCore\Admin', __DIR__ . DIRECTORY_SEPARATOR . 'Admin');
$loader->addNamespace('StoreCore\I18N', __DIR__ . DIRECTORY_SEPARATOR . 'I18N');
$loader->addNamespace('StoreCore\Modules', __DIR__ . DIRECTORY_SEPARATOR . 'Modules');
$loader->addNamespace('StoreCore\Types', __DIR__ . DIRECTORY_SEPARATOR . 'Types');
$loader->addNamespace('StoreCore', __DIR__);

// Add vendor namespaces for modules.
$loader->addNamespace('Google', __DIR__ . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . 'Google');

// Register the StoreCore autoloader.
$loader->register();

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
require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractController.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'AbstractModel.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Registry.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Request.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Response.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'Route.php';

// Load and populate the global service locator.
$registry = \StoreCore\Registry::getInstance();
$registry->set('Request', new \StoreCore\Request());
$registry->set('Autoloader', $loader);
unset($loader);

// Start logging
if (!defined('STORECORE_NULL_LOGGER')) {
    define('STORECORE_NULL_LOGGER', false);
}
if (STORECORE_NULL_LOGGER) {
    $registry->set('Logger', new \Psr\Log\NullLogger());
} else {
    $registry->set('Logger', new \StoreCore\FileSystem\Logger());
}
