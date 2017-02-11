<?php
namespace StoreCore\I18N;

/**
 * Content Language Negotiation
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2016 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class Language
{
    const VERSION = '0.1.0';

    /**
     * Match HTTP accept header.
     *
     * Parses a weighed "Accept" HTTP header and matches it against a list
     * of supported options.
     *
     * @param string $header
     *   The HTTP "Accept" header to parse.
     *
     * @param array $supported
     *   A list of supported values.
     *
     * @return string|null
     *   Returns a matched option or null if there is no match.
     */
    private function matchAcceptHeader($header, $supported)
    {
        $matches = $this->sortAcceptHeader($header);
        foreach ($matches as $key => $q) {
            if (isset($supported[$key])) {
                return $supported[$key];
            }
        }

        // If any (i.e. "*") is acceptable, return the first supported format
        if (isset($matches['*'])) {
            return array_shift($supported);
        }
        return null;
    }

    /**
     * Negotiate preferred client language.
     *
     * @param array $supported
     *   An associative array indexed by language codes (locale codes)
     *   supported by the application.  Values must evaluate to true.
     *
     * @param string $default
     *   The default language that should be used if none of the other
     *   languages are found during negotiation.  Defaults to 'en-GB' for
     *   British English.
     *
     * @return string
     */
    public function negotiate(array $supported, $default = 'en-GB')
    {
        $languages = array();
        foreach ($supported as $language => $is_supported) {
            if ($is_supported) {
                $languages[strtolower($language)] = $language;
            }
        }

        if (empty($languages)) {
            return $default;
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $match = $this->matchAcceptHeader($_SERVER['HTTP_ACCEPT_LANGUAGE'], $languages);
            if (!is_null($match)) {
                return $match;
            }
        }

        if (isset($_SERVER['REMOTE_HOST'])) {
            $language = strtolower(end($h = explode('.', $_SERVER['REMOTE_HOST'])));
            if (isset($languages[$language])) {
                return $languages[$language];
            }
        }
        return $default;
    }

    /**
     * Parse and sort a weighed "Accept" HTTP header.
     *
     * @param string $header
     *   The HTTP "Accept" header to parse.
     *
     * @return array
     *   Sorted list of "accept" options.
     */
    private function sortAcceptHeader($header)
    {
        $matches = array();
        foreach (explode(',', $header) as $option) {
            $option = array_map('trim', explode(';', $option));
            $l = strtolower($option[0]);
            if (isset($option[1])) {
                $q = (float) str_replace('q=', '', $option[1]);
            } else {
                $q = null;
                // Assign default low weight for generic values
                if ($l == '*/*') {
                    $q = 0.01;
                } elseif (substr($l, -1) == '*') {
                    $q = 0.02;
                }
            }
            // Unweighted values get high weight by their position in the list
            $matches[$l] = isset($q) ? $q : 1000 - count($matches);
        }
        arsort($matches, SORT_NUMERIC);
        return $matches;
    }
}
