<?php
namespace StoreCore\Admin;

/**
 * Minify HTML or CSS
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Admin
 * @version   0.1.0
 */
class Minifier
{
    /**
     * @var string VERSION
     */
    const VERSION = '0.1.0';

    /**
     * @param string $text
     * @param bool $css
     * @return string
     */
    public static function minify($text, $css = false)
    {
        $text = str_ireplace("\r\n", "\n", $text);
        $text = str_ireplace("\r", "\n", $text);
        $text = str_ireplace("\t", ' ', $text);
        
        $text = preg_replace('!\s+!', ' ', $text);

        if (stripos($text, '<pre') !== false) {
            $css = false;
        } else {
            $text = str_ireplace("\n", null, $text);
        }
        $text = str_ireplace('> <', '><', $text);

        if ($css === true) {
            $text = str_ireplace(': ', ':', $text);
            $text = str_ireplace(', ', ',', $text);
            $text = str_ireplace(' {', '{', $text);
            $text = str_ireplace(';}', '}', $text);
        }

        return $text;
    }
}
