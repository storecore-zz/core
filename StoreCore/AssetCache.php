<?php
namespace StoreCore;

/**
 * Asset Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class AssetCache
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     * @uses \StoreCore\Request::getMethod()
     */
    public static function find(Registry $registry)
    {
        // Only cache GET and HEAD requests.
        if (
            $registry->get('Request')->getMethod() !== 'GET'
            && $registry->get('Request')->getMethod() !== 'HEAD'
        ) {
            return;
        }

        $pathinfo = pathinfo($registry->get('Request')->getRequestPath());
        if (array_key_exists('basename', $pathinfo) && array_key_exists('extension', $pathinfo)) {
            $asset = new \StoreCore\Asset($pathinfo['basename'], $pathinfo['extension']);
        }
    }
}
