<?php
namespace StoreCore\FileSystem;

/**
 * Cache Pool for Redirects
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Redirects implements \Psr\Cache\CacheItemPoolInterface
{
    const VERSION = '0.1.0';

    /**
     * @var array $FileContents
     *   Current contents of the cache file.
     */
    private $FileContents = array();

    /**
     * @var string $FileName
     *   Filename of the JSON cache file.  By default, the cache file is stored
     *   in the main `STORECORE_FILESYSTEM_CACHE_DIR` cache directory.  This
     *   cache MAY be deleted manually to clear the redirects cache.
     */
    private $FileName;

    /**
     * @var array $NewFileContents
     *   New, unsaved additions to the cache file.
     */
    private $NewFileContents = array();

    /**
     * @param void
     * @param void
     */
    public function __construct()
    {
        if (defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
            $this->FileName = STORECORE_FILESYSTEM_CACHE_DIR  . 'data' . DIRECTORY_SEPARATOR . 'redirects.json';
        } else {
            $this->FileName = __DIR__ . DIRECTORY_SEPARATOR . 'redirects.json';
        }

        if (is_file($this->FileName)) {
            $this->FileContents = file_get_contents($this->FileName);
            $this->FileContents = json_decode($this->FileContents, true);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->NewFileContents = array();

        $handle = fopen($this->FileName, 'w');
        if ($handle === false) {
            return false;
        }

        $written = fwrite($handle, json_encode(array()));
        if ($written === false) {
            $handle = null;
            return false;
        } else {
            fclose($handle);
            $this->FileContents = array();
            return true;
        }
    }

    /**
     * @inheritDoc
     */
    public function commit()
    {
        $this->FileContents = array_merge($this->FileContents, $this->NewFileContents);
        $this->NewFileContents = array();
        return $this->fwrite();
    }

    /**
     * @inheritDoc
     */
    public function deleteItem($key)
    {
        if (array_key_exists($key, $this->FileContents) ) {
            unset($this->FileContents[$key]);
            return $this->fwrite();
        } elseif (array_key_exists($key, $this->NewFileContents) ) {
            unset($this->NewFileContents[$key]);
            return true;
        } else {
            throw new \Psr\Cache\InvalidArgumentException();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteItems(array $keys)
    {
        $existing_file_contents = $this->FileContents;
        $save_existing_file = false;

        foreach ($keys as $key) {
            if (array_key_exists($key, $existing_file_contents) ) {
                unset($existing_file_contents[$key]);
                $save_existing_file = true;
            } elseif (array_key_exists($key, $this->NewFileContents) ) {
                unset($this->NewFileContents[$key]);
            } else {
                throw new \Psr\Cache\InvalidArgumentException();
            }
        }

        if ($save_existing_file === false) {
            return true;
        } else {
            $this->FileContents = $existing_file_contents;
            return $this->fwrite();
        }
    }

    /**
     * Write the JSON encoded cache file to disk.
     *
     * @param void
     * @return bool
     */
    private function fwrite()
    {
        $handle = fopen($this->FileName, 'w');
        if ($handle === false) {
            return false;
        }

        $fwrite = fwrite($handle, json_encode($this->FileContents));
        fclose($handle);
        if ($fwrite === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get a redirect object from the redirects cache.
     *
     * @param string $key
     * @return \StoreCore\Types\Redirect
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getItem($key)
    {
        if (!is_string($key) || empty($key)) {
            throw new \Psr\Cache\InvalidArgumentException();
        }

        if (array_key_exists($key, $this->FileContents)) {
            return unserialize($this->FileContents[$key]);
        } elseif (array_key_exists($key, $this->NewFileContents)) {
            return unserialize($this->NewFileContents[$key]);
        } else {
            return new \StoreCore\Types\Redirect();
        }
    }

    /**
     * @inheritDoc
     */
    public function getItems(array $keys = array())
    {
        if (empty($keys)) {
            $items = array_merge($this->FileContents, $this->NewFileContents);
        } else {
            $items = array();
            foreach ($keys as $key) {
                if (array_key_exists($key, $this->NewFileContents)) {
                    $items[$key] = $this->NewFileContents[$key];
                } elseif (array_key_exists($key, $this->FileContents)) {
                    $items[$key] = $this->FileContents[$key];
                } else {
                    throw new \Psr\Cache\InvalidArgumentException();
                }
            }
        }

        foreach ($items as $key => $value) {
            $items[$key] = unserialize($value);
        }
        return $items;
    }

    /**
     * @inheritDoc
     */
    public function hasItem($key)
    {
        if (!is_string($key)) {
            throw new \Psr\Cache\InvalidArgumentException();
        }

        if (
            array_key_exists($key, $this->FileContents)
            || array_key_exists($key, $this->NewFileContents)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function save(\Psr\Cache\CacheItemInterface $item)
    {
        $key = $item->getKey();
        $this->FileContents[$key] = serialize($item);
        return $this->fwrite();
    }

    /**
     * @inheritDoc
     */
    public function saveDeferred(\Psr\Cache\CacheItemInterface $item)
    {
        $key = $item->getKey();
        $this->NewFileContents[$key] = serialize($item);
        return true;
    }
}
