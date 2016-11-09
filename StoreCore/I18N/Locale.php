<?php
namespace StoreCore\I18N;

/**
 * Locale Loader
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class Locale
{
    const VERSION = '0.1.0';

    /**
     * @var string DEFAULT_LANGUAGE
     *   Default language to load if no other default language is set or no
     *   other language match was found.  Defaults to 'en-GB' for British
     *   English.
     */
    const DEFAULT_LANGUAGE = 'en-GB';

    /**
     * @var string SUPPORTED_LANGUAGES
     *   Array in JSON (JavaScript Object Notation) linking ISO codes for
     *   supported languages to the status true or false.
     */
    const SUPPORTED_LANGUAGES = '{"en-GB":true,"de-DE":true,"fr-FR":true,"nl-NL":true}';

    /**
     * Load a negotiable locale from the file system cache.
     *
     * @param void
     *
     * @return string
     *   ISO code of the loaded locale.
     */
    public static function load($default_language = null)
    {
        $supported_languages = (array)json_decode(self::SUPPORTED_LANGUAGES);

        if ($default_language === null || !array_key_exists($default_language, $supported_languages)) {
            $default_language = self::DEFAULT_LANGUAGE;
        }

        $content_negotiator = new \StoreCore\I18N\Language();
        $locale = $content_negotiator->negotiate($supported_languages, $default_language);
        include STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . $locale . '.php';
        return $locale;
    }
}
