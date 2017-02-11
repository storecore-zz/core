<?php
namespace StoreCore\FileSystem;

use \StoreCore\AbstractController as AbstractController;
use \StoreCore\Database\Blacklist as BlacklistModel;
use \StoreCore\Registry as Registry;

/**
 * IP Blacklist
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 *
 * @api
 * @method static bool exists ( string $ip_address )
 * @method bool flush ( void )
 */
class Blacklist extends AbstractController
{
    const VERSION = '0.1.0';

    /**
     * Check if an IP address is blacklisted.
     *
     * @param string $ip_address
     *   Remote IPv4 or IPv6 Internet Protocol (IP) address.
     *
     * @return bool
     *   Returns true if the IP address is blacklisted, otherwise false.  This
     *   method will also return false if the cache file does not exist,
     *   is empty, or somehow could not be processed.
     */
    public static function exists($ip_address)
    {
        $ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);
        if ($ip_address === false) {
            return false;
        }

        $filename = STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'blacklist.json';
        if (!is_file($filename)) {
            return false;
        }

        $blacklist = file_get_contents($filename);
        if (false === $blacklist) {
            return false;
        }

        $blacklist = json_decode($blacklist, true);
        if (empty($blacklist) || !is_array($blacklist)) {
            return false;
        }

        return array_key_exists($ip_address, $blacklist);
    }

    /**
     * Recreate the blacklist file cache.
     *
     * @param void
     * @return bool
     */
    public function flush()
    {
        $model = new BlacklistModel(Registry::getInstance());
        $list = $model->read();

        if ($list === null) {
            $list = json_encode(array());
        } else {
            $list = json_encode($list);
        }

        $handle = fopen(STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'blacklist.json', 'w');
        if ($handle === false) {
            return false;
        }

        $written = fwrite($handle, $list);
        if ($written === false) {
            return false;
        } else {
            fclose($handle);
            return true;
        }
    }
}
