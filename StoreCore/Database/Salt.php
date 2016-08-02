<?php
namespace StoreCore\Database;

/**
 * Salt
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Salt implements \StoreCore\SingletonInterface
{
    const VERSION = '0.1.0';

    /**
     * @var string CHARACTER_SET
     *   Character set for the salt, currently set to ASCII digits (0-1),
     *   uppercase letters (A-Z), and lowercase letters (a-z).  Note that
     *   adding other characters may break code that uses the default format
     *   "./0-9A-Za-z" for Standard DES (Data Encryption Standard) or
     *   Blowfish.
     */
    const CHARACTER_SET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * Get a random salt.
     *
     * @param int $length
     *   Optional length of the salt string.  Defaults to 255 characters for
     *   a CHAR(255) column in a MySQL database table.  The salt length is
     *   reset to a minimum of 2 characters for very short salts used by
     *   Standard DES (Data Encryption Standard).
     *
     * @return string
     */
    public static function getInstance($length = 255)
    {
        if (!is_int($length)) {
            $length = 255;
        } elseif ($length < 2) {
            $length = 2;
        }

        $charset = str_shuffle(self::CHARACTER_SET);
        $charset_size = strlen($charset) - 1;
        $salt = (string)null;
        for ($i = 0; $i < $length; $i++) {
            $salt .= $charset[mt_rand(0, $charset_size)];
        }
        return $salt;
    }
}
