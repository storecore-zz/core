<?php
namespace StoreCore\Admin;

/**
 * Minify HTML or CSS
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @method    string Minifier::minify ( string $str [, bool $css = false ] )
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Minifier
{
    /**
     * @var string VERSION
     */
    const VERSION = '0.1.0';

    /**
     * @param string $str
     * @param bool $css
     * @return string
     */
    public static function minify($str, $css = false)
    {
        $str = str_ireplace("\r\n", "\n", $str);
        $str = str_ireplace("\r", "\n", $str);
        $str = str_ireplace("\t", ' ', $str);

        $str = preg_replace('!\s+!', ' ', $str);

        if (stripos($str, '<pre') !== false) {
            $css = false;
        } else {
            $str = str_ireplace("\n", null, $str);
        }
        $str = str_ireplace('> <', '><', $str);

        if ($css === true) {
            $str = str_ireplace(': ', ':', $str);
            $str = str_ireplace(', ', ',', $str);
            $str = str_ireplace(' {', '{', $str);
            $str = str_ireplace(';}', '}', $str);
        }

        return $str;
    }
}
