<?php
namespace StoreCore\Database;

/**
 * Salt
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore\Database
 * @version   0.0.2
 */
class Salt
{
    /**
     * @type string CHARACTER_SET
     *      Character set for the salt, currently set to ASCII digits (0-1),
     *      uppercase letters (A-Z), and lowercase letters (a-z).
     */
    const CHARACTER_SET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
   
    /**
     * @type string VERSION
     */
    const VERSION = '0.0.2';

    /**
     * Get a random salt.
     *
     * @param int $length
     *     Optional length of the salt string.  Defaults to 255 characters for
     *     a CHAR(255) column in a MySQL database table.  The salt length is
     *     reset to a minimum of 8 characters for very short salts.
     *
     * @return string
     */
    public static function getInstance($length = 255)
    {
        if (!is_int($length)) {
            $length = 255;
        } elseif ($length < 8) {
            $length = 8;
        }

        $charset = str_shuffle(self::CHARACTER_SET);
        $charset_size = strlen($charset);
        $salt = (string)null;
        for ($i = 0; $i < $length; $i++) {
            $salt .= $charset[mt_rand(0, $charset_size - 1)];
        }
        return $salt;
    }
}
