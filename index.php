<?php
/**
 * StoreCore Store Front Application
 *
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version   1.0.0-beta.1
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

// Working directory
define('STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR', rtrim(__DIR__, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

// Boot
if (!defined('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR')) {
    define('STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR', STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'StoreCore' . DIRECTORY_SEPARATOR);
}
require STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'bootloader.php';

// Refuse requests from a blacklisted client IP address.
if (\StoreCore\FileSystem\Blacklist::has($registry->get('Server')->getRemoteAddress())) {
    $response = new \StoreCore\Response($registry);
    $response->setCompression(0);
    $response->addHeader('HTTP/1.1 403 Forbidden');
    $response->output();
    $registry->get('Logger')->info('HTTP/1.1 403 Forbidden: client IP address ' . $registry->get('Server')->getRemoteAddress() . ' is blacklisted.');
    exit;
}

// Silently publish an asset, if it exists.
\StoreCore\AssetCache::find($registry);
// Find a matching cached webpage.
\StoreCore\FullPageCache::find($registry);

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

// Attach session observers.
\StoreCore\SubjectObservers::populate($session);

// Load a language pack
$language = $session->get('Language');
if ($language == null) {
    if ($registry->get('Cookies')->has('Language')) {
        $cookie_language = $registry->get('Cookies')->get('Language');
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
switch ($registry->get('Request')->getRequestTarget()) {
    // Admin web app manifest:
    case '/admin/manifest.json':
    case '/admin/StoreCore.webmanifest':
        $route = new Route('/admin/StoreCore.webmanifest', '\StoreCore\Admin\ManifestController');
        break;
    // Admin service worker JavaScript, requires /admin/ in the URL:
    case '/admin/ServiceWorker.js':
    case '/admin/sw.js':
        $route = new \StoreCore\Route('/admin/ServiceWorker.js', '\StoreCore\Admin\ServiceWorker');
        break;
    // Admin lock screen:
    case '/admin/lock':
    case '/admin/lock/':
        $route = new \StoreCore\Route('/admin/lock/', '\StoreCore\Admin\LockScreen');
        break;
    // Admin sign-in:
    case '/admin/sign-in/':
        $route = new \StoreCore\Route('/admin/sign-in/', '\StoreCore\Admin\SignIn');
        break;
    // robots.txt:
    case '/robots.txt':
        $route = new \StoreCore\Route('/robots.txt', '\StoreCore\FileSystem\Robots');
        break;
    // Fallback to some other (admin) route or a fixed redirect:
    default:
        // Execute an administration route.
        if (strpos($registry->get('Request')->getRequestTarget(), '/admin/', 0) === 0) {
            $route = new \StoreCore\Route('/admin/', '\StoreCore\Admin\FrontController');
            break;
        }

        // Execute a redirect if a destination is found.
        \StoreCore\Redirector::find($registry->get('Request'));

        // Find some other route.
        $route_factory = new \StoreCore\Database\RouteFactory($registry);
        $route = $route_factory->find();
        if ($route === null) {
            $route = false;
        }
}

// Dispatch
if ($route !== false) {
    $registry->set('Route', $route);
    $route->dispatch();
} else {
    $registry->get('Logger')->notice('HTTP/1.1 404 Not Found: ' . $registry->get('Request')->getRequestTarget());
    $response = new \StoreCore\Response($registry);
    $response->addHeader('HTTP/1.1 404 Not Found');
    $response->output();
}

// Statistics and analytics
if (defined('STORECORE_BI') && STORECORE_BI == true) {
    if (array_key_exists('HTTP_USER_AGENT', $registry->get('Server')->getServerParams())) {
        $user_agent = $registry->get('Server')->getServerParams()['HTTP_USER_AGENT'];
        $user_agent_mapper = new \StoreCore\Database\UserAgent($registry);
        $user_agent_mapper->setUserAgent($user_agent);
        $user_agent_mapper->update();
    }
}
