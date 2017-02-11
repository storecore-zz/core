<?php
namespace StoreCore\FileSystem;

use \StoreCore\Registry as Registry;
use \StoreCore\Database\Languages as Languages;
use \StoreCore\Database\TranslationMemory as TranslationMemory;
use \StoreCore\FileSystem\Logger as Logger;

/**
 * Translation Memory Cache.
 *
 * This file system helper contains a single static `rebuild()` method to
 * update language pack files in the `/cache/data/` directory.  Updates are
 * limited to languages that are currently enabled.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class TranslationMemoryCache
{
    /** @var string VERSION Semantic Version (SemVer). */
    const VERSION = '0.1.0';

    /**
     * Rebuild the cached language packs.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public static function rebuild()
    {
        $registry = Registry::getInstance();
        if ($registry->has('Logger')) {
            $logger = $registry->get('Logger');
        } else {
            $logger = new Logger();
        }

        // Restore the data cache (sub)directory if it does not exist.
        if (!defined('STORECORE_FILESYSTEM_CACHE_DATA_DIR')) {
            if (!defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
                $logger->error('Global cache directory is not defined.');
                return false;
            } else {
                $cache_directory = STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR;
                if (!is_dir($cache_directory)) {
                    if (!mkdir($cache_directory, 0755)) {
                        $logger->error('Could not create data cache directory ' . $cache_directory . '.');
                    } else {
                        $logger->error('Data cache directory ' . $cache_directory . ' does not exist.');
                    }
                    return false;
                } else {
                    define('STORECORE_FILESYSTEM_CACHE_DATA_DIR', $cache_directory);
                    unset($cache_directory);
                }
            }
        }

        if (!is_writable(STORECORE_FILESYSTEM_CACHE_DATA_DIR)) {
            $logger->error('Data cache directory ' . STORECORE_FILESYSTEM_CACHE_DATA_DIR . ' is not writeable.');
            return false;
        }

        $language_model = new Languages($registry);
        $languages = $language_model->getEnabledLanguages();
        unset($language_model);

        $tm = new TranslationMemory($registry);
        foreach ($languages as $language_id => $language_description) {
            $translations = $tm->getTranslations($language_id, false);
            $file = '<?php' . "\n";
            foreach ($translations as $name => $value) {
                $file .= "define('StoreCore\\\\I18N\\\\{$name}', '{$value}');" . "\n";
            }
            if (file_put_contents(STORECORE_FILESYSTEM_CACHE_DATA_DIR . $language_id . '.php', $file) === false) {
                $logger->error('Language cache file for ' . $language_id . '(' . $language_description . ')' . ' could not be written.');
                return false;
            }
        }
        return true;
    }
}
