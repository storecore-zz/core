<?php
namespace StoreCore;

use Psr\Http\Message\StreamInterface;
use StoreCore\Types\StringableInterface;

/**
 * Abstract stream resource for HTTP messages.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
abstract class AbstractStream implements StreamInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var bool $Readable
     *   Stream is readable (true) or not readable (default false).  Please use
     *   the `isReadable()` method to determine if the stream is readable.
     */
    protected $Readable = false;

    /**
     * @var int|null $Size
     *   Size of the stream in bytes if known, or null if unknown.
     */
    protected $Size = null;

    /**
     * @var resource $StreamResource
     *   Resource (handle) of a stream.
     */
    protected $StreamResource;

    /**
     * @var bool $Writable
     *   Stream is writable (true) or not writable (default false).  Use the
     *   `isWritable()` method to determine if stream is writable.
     */
    protected $Writable = false;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        if (!$this->isReadable()) {
            return (string)null;
        }

        try {
            $this->seek(0);
            return (string) $this->getContents();
        } catch (\Exception $e) {
            return (string)null;
        }
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        if (is_resource($this->StreamResource) && get_resource_type($this->StreamResource) === 'stream') {
            fclose($this->StreamResource);
        }
    }

    /**
     * @inheritDoc
     */
    final public function detach()
    {
        if (!isset($this->StreamResource)) {
            return null;
        }

        $return = $this->StreamResource;
        unset($this->StreamResource);
        $this->Readable = false;
        $this->Writable = false;
        return $result;
    }

    /**
     * @inheritDoc
     */
    final public function eof()
    {
        if (is_resource($this->StreamResource) && get_resource_type($this->StreamResource) === 'stream') {
            $metadata = stream_get_meta_data($this->StreamResource);
            if (isset($metadata['eof'])) {
                return $metadata['eof'];
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException();
        }

        $contents = stream_get_contents($this->StreamResource);
        if ($contents === false) {
            throw new \RuntimeException();
        } else {
            return $contents;
        }
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        if (!is_resource($this->StreamResource) || get_resource_type($this->StreamResource) !== 'stream') {
            return null;
        }

        $metadata = stream_get_meta_data();
        if ($key === null) {
            return $metadata;
        } elseif (array_key_exists($key, $metadata)) {
            return $metadata[$key];
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     * 
     * This implementation of the `StreamInterface::getSize()` method
     * immediately returns a previously determined stream size, if it exists.
     * Operations that change the size, such as `write()`, therefore MUST
     * either set a new size or reset the size to null.
     */
    public function getSize()
    {
        if ($this->Size !== null) {
            return $this->Size;
        }

        if (!is_resource($this->StreamResource)) {
            return null;
        }

        $stats = fstat($this->StreamResource);
        if (isset($stats['size'])) {
            $this->Size = $stats['size'];
            return $this->Size;
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    final public function isReadable()
    {
        return $this->Readable;
    }

    /**
     * @inheritDoc
     */
    final public function isSeekable()
    {
        if (is_resource($this->StreamResource) && get_resource_type($this->StreamResource) === 'stream') {
            $metadata = stream_get_meta_data($this->StreamResource);
            if (isset($metadata['seekable'])) {
                return $metadata['seekable'];
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    final public function isWritable()
    {
        return $this->Writable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException('Stream is not readable');
        } else {
            return fread($this->stream, $length);
        }
    }

    /**
     * @inheritDoc
     */
    final public function rewind()
    {
        $this->seek(0);
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->isSeekable()) {
            throw new \RuntimeException('Stream is not seekable');
        } elseif (fseek($this->StreamResource, $offset, $whence) === -1) {
            throw new \RuntimeException('Unable to seek to stream position ' . $offset . ' with whence ' . var_export($whence, true));
        }
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        $result = ftell($this->StreamResource);
        if ($result === false) {
             throw new \RuntimeException('Unable to determine stream position');
        } else {
            return $result;
        }
    }

    /**
     * @inheritDoc
     */
    abstract public function write($string);
}
