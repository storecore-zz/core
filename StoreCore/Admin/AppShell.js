/**
 * StoreCore Admin App Shell
 *
 * The following JavaScript first registers a service worker.
 * Note the use of directory names as data domains: the service worker
 * `/admin/sw.js` controls pages whose URL begins with `/admin/`.
 *
 * @author    Ward van der Put <ward.vanderput@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/admin/sw.js').then(function(registration) {
      console.log('Service worker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
      console.log('Service worker registration failed: ', err);
    });
  });
}
