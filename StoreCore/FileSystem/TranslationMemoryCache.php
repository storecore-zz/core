<?php
namespace StoreCore\FileSystem;

use \StoreCore\Database\Languages as Languages;
use \StoreCore\Database\TranslationMemory as TranslationMemory;
use \StoreCore\FileSystem\Logger as Logger;

/**
 * Translation Memory Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class TranslationMemoryCache
{
    const VERSION = '0.1.0';

    /**
     * Rebuild the cached language packs.
     *
     * @param void
     * @return bool
     */
    public static function rebuild()
    {
        $logger = new Logger();

        if (!defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
            $logger->error('Cache directory is not defined.');
            return false;
        }

        $cache_directory = STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR;
        if (!is_dir($cache_directory)) {
            if (!mkdir($cache_directory, 0755)) {
                $logger->error('Could not create cache directory ' . $cache_directory);
                return false;
            }
        }

        if (!is_writable($cache_directory)) {
            $logger->error('Cache directory ' . $cache_directory . ' is not writeable.');
            return false;
        }

        $registry = \StoreCore\Registry::getInstance();
        $language_model = new Languages($registry);
        $languages = $language_model->getEnabledLanguages();
        unset($language_model);

        $tm = new TranslationMemory($registry);
        foreach ($languages as $language_id => $iso_code) {
            $translations = $tm->getTranslations($language_id, false);
            $file = '<?php' . PHP_EOL;
            foreach ($translations as $name => $value) {
                $file .= "define('StoreCore\\\\I18N\\\\{$name}', '{$value}');" . PHP_EOL;
            }
            if (file_put_contents($cache_directory . $iso_code . '.php', $file) === false) {
                $logger->error('Language cache file for ' . $iso_code . ' could not be written.');
                return false;
            }
        }
        return true;
    }
}
