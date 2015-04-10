<?php
namespace StoreCore\Admin;

class Minifier
{
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
        $text = str_ireplace("\n    ", "\n", $text);
        $text = str_ireplace("\n  ", "\n", $text);

        if (stripos($text, '<pre') !== false) {
            $css = false;
        } else {
            $text = str_ireplace("\n", null, $text);
        }

        if ($css === true) {
            $text = str_ireplace(': ', ':', $text);
            $text = str_ireplace(', ', ',', $text);
            $text = str_ireplace(' {', '{', $text);
            $text = str_ireplace(';}', '}', $text);
        }

        return $text;
    }
}
