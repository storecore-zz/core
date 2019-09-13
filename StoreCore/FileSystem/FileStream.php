<?php
namespace StoreCore\FileSystem;

use \Psr\Http\Message\StreamInterface;
use \StoreCore\AbstractStream;

/**
 * PSR-compliant file stream.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class FileStream extends AbstractStream implements StreamInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $ReadableModes
     *   Readable file stream modes.
     */
    protected $ReadableModes = array('a+', 'c+', 'r', 'r+', 'w+', 'x+');

    /**
     * @var array $WritableModes
     *   Writable file stream modes.
     */
    protected $WritableModes = array('a', 'a+', 'c', 'c+', 'r+', 'w', 'w+', 'x', 'x+');

    /**
     * Create file stream.
     *
     * @param string $filename 
     *   The filename to use as basis of the stream.
     *
     * @param string $mode
     *   File open modes as used by `fopen()`.  Defaults to `r+` for a file
     *   stream that is readable and writable.
     *
     * @return self
     */
    public function __construct($filename, $mode = 'r+')
    {
        if (!is_string($mode) ) {
            throw new \InvalidArgumentException();
        }

        $mode = trim($mode);
        $mode = strtolower($mode);
        if (empty($mode)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects parameter 2 to be valid fopen() mode');
        }

        // Strip `b` (binary) and `t` (translate) flags
        $unflagged_mode = str_replace(array('b', 't'), '', $mode);
        if (!in_array($unflagged_mode, $this->ReadableModes) && !in_array($unflagged_mode, $this->WritableModes)) {
            throw new \InvalidArgumentException(__METHOD__ . ' does not support file read/write mode ' . $mode);
        }

        // Error abstraction with exception chaining: PSR-17 requires
        // an SPL RuntimeException if the file cannot be opened.
        try {
            $this->StreamResource = fopen($filename, $mode);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        if (in_array($unflagged_mode, $this->ReadableModes)) {
            $this->Readable = true;
        }
        if (in_array($unflagged_mode, $this->WritableModes)) {
            $this->Writable = true;
        }
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        if (empty($string)) {
            return 0;
        }

        if (!$this->isWritable()) {
            throw new \RuntimeException('File stream is not writable');
        }

        $written = fwrite($this->StreamResource, $string);
        if ($written === false) {
            throw new \RuntimeException('Error writing to file stream');
        } else {
            $this->Size = null;
            return $written;
        }
    }
}
