<?php
namespace StoreCore\I18N;

/**
 * Locale Loader
 *
 * This system helper class contains a single static `load()` method to load a
 * StoreCore language pack.  If the static `load()` method is called with an
 * ISO language/locale string, the language pack of the requested language is
 * loaded.  If the `load()` method is called without a specific language
 * string, the method is able to load a language pack through HTTP content
 * negation with the client.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class Locale
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string DEFAULT_LANGUAGE
     *   Default language to load if no other default language is set or no
     *   other language match was found.  Defaults to `en-GB` for British
     *   English.
     */
    const DEFAULT_LANGUAGE = 'en-GB';

    /**
     * @var string SUPPORTED_LANGUAGES
     *   Array in JSON (JavaScript Object Notation) linking ISO codes for
     *   supported languages to the status true or false.  Languages supported
     *   by default are `en-GB` and `en-US` (British and American English),
     *   `de-DE` (German), `fr-FR` (French), and `nl-NL` (Dutch).
     */
    const SUPPORTED_LANGUAGES = '{"en-GB":true,"en-US":true,"de-DE":true,"fr-FR":true,"nl-NL":true}';

    /**
     * Load a negotiable locale from the file system cache.
     *
     * @param string $default_language
     *   Optional ISO code of the locale to load.  If this parameter is not set
     *   or the requested language is not (yet) supported, the system root
     *   language `en-GB` (British English) defined in the class constant
     *    `DEFAULT_LANGUAGE` is loaded.
     *
     * @return string
     *   ISO code of the loaded locale.
     *
     * @uses \StoreCore\I18N\Language::negotiate()
     */
    public static function load($default_language = null)
    {
        $supported_languages = (array)json_decode(self::SUPPORTED_LANGUAGES);

        if ($default_language === null || !array_key_exists($default_language, $supported_languages)) {
            $default_language = self::DEFAULT_LANGUAGE;
        }

        $content_negotiator = new \StoreCore\I18N\Language();
        $locale = $content_negotiator->negotiate($supported_languages, $default_language);
        include STORECORE_FILESYSTEM_CACHE_DATA_DIR . $locale . '.php';
        return $locale;
    }
}
