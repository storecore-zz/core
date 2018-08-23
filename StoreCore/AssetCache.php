<?php
namespace StoreCore;

/**
 * Asset Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class AssetCache
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Find and silently publish an asset.
     *
     * @param \StoreCore\Registry $registry
     *   Global service locator.
     *
     * @return void
     *
     * @uses \StoreCore\Request::getMethod()
     *   The asset cache is touched only for HTTP requests that use the GET or
     *   HEAD method.
     */
    public static function find(Registry $registry)
    {
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
