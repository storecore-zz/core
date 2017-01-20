<?php
namespace StoreCore\Database;

/**
 * Token to Reset Passwords
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore\Security
 * @version   0.0.1
 */
class PasswordResetToken
{
    /**
     * @var string CHARACTER_SET
     *   Character set for the token, currently set to ASCII digits and
     *   uppercase letters.  The digits 0 and 1 and the letters I and O are
     *   omitted, as these characters MAY be confusing to users in case they
     *   have to be entered in a form.
     */
    const CHARACTER_SET = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.0.1';

    /**
     * Get a random token.
     *
     * @param int $length
     *   Optional length of the token string.  Defaults to 16 characters for
     *   a fixed-width CHAR(16) column in a MySQL database table.
     *
     * @return string
     */
    public static function getInstance($length = 16)
    {
        if (!is_int($length)) {
            $length = 16;
        }

        $charset = str_shuffle(self::CHARACTER_SET);
        $charset_size = strlen($charset);
        $token = (string)null;
        for ($i = 0; $i < $length; $i++) {
            $token .= $charset[mt_rand(0, $charset_size - 1)];
        }
        return $token;
    }
}
