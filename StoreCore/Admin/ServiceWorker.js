/**
 * Service Worker
 *
 * @author    Ward van der Put <ward.vanderput@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */

/**
 * @see https://github.com/dominiccooney/cache-polyfill
 *      Service worker cache polyfill
 */
importScripts('/scripts/cache-polyfill.js');

self.addEventListener('install', function(e) {
  e.waitUntil(
    caches.open('StoreCoreAdminCache').then(function(cache) {
      return cache.addAll([
        '/admin/',
        '/admin/StoreCore.webmanifest',
        '/styles/admin.min.css',
        '/scripts/material.min.js',
        '/images/StoreCore-icon-144x144.png',
        '/images/StoreCore-icon-192x192.png',
        '/images/StoreCore-icon-256x256.png',
        '/images/StoreCore-icon-384x384.png',
        '/images/StoreCore-icon-512x512.png'
      ]);
    })
  );
});
