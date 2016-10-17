<?php
namespace StoreCore\FileSystem;

/**
 * File Cache
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class FileCache extends \StoreCore\FileSystem\FileCacheReader
{
    const VERSION = '0.1.0';

    /**
     * Create a cache file.
     *
     * @param \StoreCore\Types\CacheKey $key
     *
     * @param \StoreCore\Document $document
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function create(\StoreCore\Types\CacheKey $key, \StoreCore\Document $document)
    {
        $this->setFileName($key);

        $fh = fopen($this->getFileName(), 'w');
        if ($fh === false) {
            return false;
        } else {
            if (fwrite($fh, $document->getDocument()) === false) {
                return false;
            } else {
                fclose($fh);
                unset($fh);
                return true;
            }
        }
    }

    /**
     * Delete a cache file.
     *
     * @param \StoreCore\Types\CacheKey|null $key
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function delete(\StoreCore\Types\CacheKey $key = null)
    {
        if ($key !== null) {
            $this->setFileName($key);
        }

        if ($this->exists($this->getFileName())) {
            return unlink($this->getFileName());
        } else {
            return false;
        }
    }

    /**
     * Delete all web page cache files.
     *
     * @param void
     * @return void
     */
    public function flush()
    {
        array_map('unlink', glob(STORECORE_FILESYSTEM_CACHE_DIR . '/pages/*.tmp'));
    }
}
