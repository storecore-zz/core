<?php
namespace StoreCore\FileSystem;

/**
 * File Cache Reader
 *
 * This helper class contains methods to handle cached web page files.
 * By default, cached web pages are stored as .tmp HTML text files in the
 * /cache/pages/ subdirectory.  The main /cache/ directory is defined by the
 * global constant \StoreCore\FileSystem\CACHE_DIR.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Catalog
 * @version   0.1.0-alpha.1
 */
class FileCacheReader
{
    const VERSION = '0.1.0-alpha.1';

    /** @var string $FileName */
    private $FileName;

    /**
     * @param \StoreCore\Types\CacheKey|null $key
     *   Optional cache key.  The cache key MAY be supplied at a later stage
     *   through one of the other public class methods.
     */
    public function __construct(\StoreCore\Types\CacheKey $key = null)
    {
        if ($key !== null) {
            $this->setFileName($key);
        }
    }

    /**
     * Check if a cache file exists.
     *
     * @param \StoreCore\Types\CacheKey|null $key
     * @return bool
     */
    public function exists(\StoreCore\Types\CacheKey $key = null)
    {
        if (!defined('\\StoreCore\\FileSystem\\CACHE_DIR')) {
            return false;
        }

        if ($key !== null) {
            $this->setFileName($key);
        }

        if (is_file($this->getFileName()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the cache file modification time.
     *
     * @param \StoreCore\Types\CacheKey|null $key
     *
     * @return int|false
     *   Returns the time the cache file was last modified as a Unix timestamp,
     *   or false on failure.
     */
    public function getFileModificationTimestamp(\StoreCore\Types\CacheKey $key = null)
    {
        if ($key !== null) {
            $this->setFileName($key);
        }
        return filemtime($this->getFileName());
    }

    /**
     * Get the filename of the cache file.
     *
     * @param void
     * @return string|null
     */
    public function getFileName()
    {
        return $this->FileName;
    }

    /**
     * Get the contents of a cache file.
     *
     * @param \StoreCore\Types\CacheKey|null $key
     *
     * @return string|false
     *   Returns the full contents of a cache file or false on failure.
     */
    public function read(\StoreCore\Types\CacheKey $key = null)
    {
        if ($key !== null) {
            $this->setFileName($key);
        }
        return file_get_contents($this->getFileName());
    }

    /**
     * Set the full cache file path.
     *
     * @param \StoreCore\Types\CacheKey $key
     * @return void
     */
    private function setFileName(\StoreCore\Types\CacheKey $key)
    {
        if (!defined('\\StoreCore\\FileSystem\\CACHE_DIR')) {
            return;
        }
        $this->FileName = \StoreCore\FileSystem\CACHE_DIR . 'pages' . DIRECTORY_SEPARATOR . $key . '.tmp';
    }
}
