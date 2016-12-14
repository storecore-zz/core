<?php
/**
 * StoreCore Store Front Application
 *
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version   0.1.0-alpha.1
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

// Boot
if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'StoreCore' . DIRECTORY_SEPARATOR);
}
require STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'bootloader.php';

// Working directory
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

// Cache directory
if (!defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
    define('STORECORE_FILESYSTEM_CACHE_DIR', STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'cache' . DIRECTORY_SEPARATOR);
}

// Logging
if (!defined('STORECORE_FILESYSTEM_LOGS_DIR')) {
    define('STORECORE_FILESYSTEM_LOGS_DIR', STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'logs' . DIRECTORY_SEPARATOR);
}
if (!defined('STORECORE_NULL_LOGGER')) {
    define('STORECORE_NULL_LOGGER', false);
}
if (STORECORE_NULL_LOGGER) {
    $logger = new \Psr\Log\NullLogger();
} else {
    $logger = new \StoreCore\FileSystem\Logger();
}

// Load and populate the global service locator.
$registry = \StoreCore\Registry::getInstance();
$request = new \StoreCore\Request();
$registry->set('Logger', $logger);

// Refuse requests from a blacklisted client IP address.
if (\StoreCore\FileSystem\Blacklist::exists($request->getRemoteAddress())) {
    $response = new \StoreCore\Response($registry);
    $response->setCompression(0);
    $response->addHeader('HTTP/1.1 403 Forbidden');
    $response->output();
    $logger->info('HTTP/1.1 403 Forbidden: client IP address ' . $_SERVER['REMOTE_ADDR'] . ' is blacklisted.');
    exit;
}

// Add an undenied request to the registry.
$registry->set('Request', $request);

// Start or restart and optionally destroy a session.
$session = new \StoreCore\Session();
if (defined('STORECORE_KILL_SWITCH') && STORECORE_KILL_SWITCH == true) {
    $response = new \StoreCore\Response($registry);
    $session->destroy();
    $response->setCompression(0);
    $response->addHeader('HTTP/1.1 503 Service Unavailable');
    $response->addHeader('Retry-After: 3600');
    $response->output();
    exit;
}

// Load a language pack
$language = $session->get('Language');
if ($language == null) {
    if ($request->hasCookie('Language')) {
        $cookie_language = $request->getCookie('Language');
        $cookie_language = base64_decode($cookie_language);
        $cookie_language = strip_tags($cookie_language);
        if (strlen($cookie_language) == 5) {
            $language = $cookie_language;
        }
        unset($cookie_language);
    }
}

if ($language == null) {
    $language = \StoreCore\I18N\Locale::load();
} else {
    $language = \StoreCore\I18N\Locale::load($language);
}

setcookie('Language', base64_encode($language), time() + 7776000, '/');
$session->set('Language', $language);
$registry->set('Session', $session);

// Run the installer on a missing installed version ID.
if (!defined('STORECORE_VERSION_INSTALLED')) {
    $route = new \StoreCore\Route('/install/', '\StoreCore\Admin\FrontController', 'install');
    $route->dispatch();
    exit;
}

// Routing
$route = false;
switch ($request->getRequestPath()) {
    case '/admin/lock/':
        $route = new \StoreCore\Route('/admin/lock/', '\StoreCore\Admin\LockScreen');
        break;
    case '/admin/sign-in/':
        $route = new \StoreCore\Route('/admin/sign-in/', '\StoreCore\Admin\SignIn');
        break;
    case '/admin/sign-out/':
        $route = new \StoreCore\Route('/admin/sign-out/', '\StoreCore\Admin\User', 'signOut');
        break;
    case '/robots.txt':
        $route = new \StoreCore\Route('/robots.txt', '\StoreCore\FileSystem\Robots');
        break;
    default:
        // Load an asset.
        $pathinfo = pathinfo($request->getRequestPath());
        if (array_key_exists('basename', $pathinfo) && array_key_exists('extension', $pathinfo)) {
            $asset = new \StoreCore\Asset($pathinfo['basename'], $pathinfo['extension']);
            unset($asset, $pathinfo);
        }

        // Execute an administration route.
        if (strpos($request->getRequestPath(), '/admin/', 0) === 0) {
            $route = new \StoreCore\Route('/admin/', '\StoreCore\Admin\FrontController');
        }

        // Execute a redirect if a destination is found.
        \StoreCore\Redirector::find();
}

if ($route !== false) {
    $route->dispatch();
} else {
    $logger->notice('HTTP/1.1 404 Not Found: ' . $request->getRequestPath());
    $response = new \StoreCore\Response($registry);
    $response->addHeader('HTTP/1.1 404 Not Found');
}

// Statistics and analytics
if (defined('STORECORE_BI') && STORECORE_BI == true) {
    $request = $registry->get('Request');
    $user_agent = $request->getUserAgent();
    $user_agent_mapper = new \StoreCore\Database\UserAgent($registry);
    $user_agent_mapper->setUserAgent($user_agent);
    $user_agent_mapper->update();
}
