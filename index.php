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

// Working directory
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

// Cache directory
if (!defined('STORECORE_FILESYSTEM_CACHE')) {
    define('STORECORE_FILESYSTEM_CACHE', STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'cache' . DIRECTORY_SEPARATOR);
}

// Logging
if (!defined('STORECORE_FILESYSTEM_LOGS')) {
    define('STORECORE_FILESYSTEM_LOGS', STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'logs' . DIRECTORY_SEPARATOR);
}
if (STORECORE_NULL_LOGGER) {
    $logger = new \Psr\Log\NullLogger();
} else {
    $logger = new \StoreCore\FileSystem\Logger();
}

// Load and populate the global service locator
$registry = \StoreCore\Registry::getInstance();
$registry->set('Logger', $logger);
$request = new \StoreCore\Request();
$registry->set('Request', $request);

$session = new \StoreCore\Session();
if (STORECORE_KILL_SWITCH) {
    $response = new \StoreCore\Response($registry);
    $session->destroy();
    $response->setCompression(0);
    $response->addHeader('HTTP/1.1 503 Service Unavailable');
    $response->addheader('Retry-After: 3600');
    $response->output();
    exit;
}
$registry->set('Session', $session);

// Routing
$route = false;
switch ($request->getRequestPath()) {
    case '/robots.txt':
        $route = new \StoreCore\Route('/robots.txt', '\StoreCore\FileSystem\Robots');
        break;
    default:
        $pathinfo = pathinfo($request->getRequestPath());
        if (array_key_exists('basename', $pathinfo) && array_key_exists('extension', $pathinfo)) {
            $asset = new \StoreCore\Asset($pathinfo['basename'], $pathinfo['extension']);
        }
        unset($pathinfo);
}

if ($route !== false) {
    $route->dispatch();
} elseif (!defined('STORECORE_INSTALLED')) {
    $front_controller = new \StoreCore\Admin\FrontController($registry);
    $front_controller->install();
} else {
    $logger->notice('HTTP/1.1 404 Not Found: ' . $request->getRequestPath());
    $response = new \StoreCore\Response($registry);
    $response->addHeader('HTTP/1.1 404 Not Found');
}

// Statistics and analytics
if (STORECORE_STATISTICS) {
    $request = $registry->get('Request');
    $user_agent = $request->getUserAgent();
    $user_agent_mapper = new \StoreCore\Database\UserAgent($user_agent);
    $user_agent_mapper->update();
}
