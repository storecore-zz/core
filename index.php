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
$parent_directory = realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR;
if (is_file($parent_directory . 'config.php')) {
    require $parent_directory . 'config.php';
} else {
    require 'config.php';
}
unset($parent_directory);

// Boot
if (!defined('\\StoreCore\\FileSystem\\LIBRARY_ROOT_DIR')) {
    define('StoreCore\\FileSystem\\LIBRARY_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'StoreCore' . DIRECTORY_SEPARATOR);
}
require \StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'bootloader.php';

// Working directory
define('StoreCore\\FileSystem\\STOREFRONT_ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

// Cache directory
if (!defined('\\StoreCore\\FileSystem\\CACHE_DIR')) {
    define('StoreCore\\FileSystem\\CACHE_DIR', \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'cache' . DIRECTORY_SEPARATOR);
}

// Logging
if (!defined('\\StoreCore\\FileSystem\\LOGS_DIR')) {
    define('StoreCore\\FileSystem\\LOGS_DIR', \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'logs' . DIRECTORY_SEPARATOR);
}
if (defined('\\StoreCore\\NULL_LOGGER') && \StoreCore\NULL_LOGGER == true) {
    $logger = new \Psr\Log\NullLogger();
} else {
    $logger = new \StoreCore\FileSystem\Logger();
}

// Load and populate the global service locator.
$registry = \StoreCore\Registry::getInstance();
$registry->set('Logger', $logger);

// Refuse requests from a blacklisted client IP address.
if (\StoreCore\FileSystem\Blacklist::exists($_SERVER['REMOTE_ADDR'])) {
    $response = new \StoreCore\Response($registry);
    $response->setCompression(0);
    $response->addHeader('HTTP/1.1 403 Forbidden');
    $response->output();
    $logger->info('HTTP/1.1 403 Forbidden: client IP address is blacklisted.');
    exit;
} else {
    $request = new \StoreCore\Request();
    $registry->set('Request', $request);
}

$session = new \StoreCore\Session();
if (defined('\\StoreCore\\KILL_SWITCH') && \StoreCore\KILL_SWITCH == true) {
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
        $pathinfo = pathinfo($request->getRequestPath());
        if (array_key_exists('basename', $pathinfo) && array_key_exists('extension', $pathinfo)) {
            $asset = new \StoreCore\Asset($pathinfo['basename'], $pathinfo['extension']);
            unset($asset, $pathinfo);
        }

        if (!defined('StoreCore\\VERSION_INSTALLED')) {
            $route = new \StoreCore\Route('/install/', '\StoreCore\Admin\FrontController', 'install');
        } elseif (strpos($request->getRequestPath(), '/admin/', 0) === 0) {
            $route = new \StoreCore\Route('/admin/', '\StoreCore\Admin\FrontController');
        }
}

if ($route !== false) {
    $route->dispatch();
} else {
    $logger->notice('HTTP/1.1 404 Not Found: ' . $request->getRequestPath());
    $response = new \StoreCore\Response($registry);
    $response->addHeader('HTTP/1.1 404 Not Found');
}

// Statistics and analytics
if (defined('\\StoreCore\\STATISTICS') && \StoreCore\STATISTICS == true) {
    $request = $registry->get('Request');
    $user_agent = $request->getUserAgent();
    $user_agent_mapper = new \StoreCore\Database\UserAgent($user_agent);
    $user_agent_mapper->update();
}
