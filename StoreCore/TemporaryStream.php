<?php
namespace StoreCore;

use \Psr\Http\Message\StreamInterface;
use \StoreCore\AbstractStream;

/**
 * Temporary HTTP message stream
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class TemporaryStream extends AbstractStream implements StreamInterface
{
    /**
     * @var string FILENAME
     *   Stream filename for `fopen()`.
     */
    const FILENAME = 'php://temp';

    /**
     * @var string MODE
     *   Stream I/O mode for `fopen()`.
     */
    const MODE = 'r+';

    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Create a temporary stream.
     *
     * @param string $content 
     *   Optional string content with which to populate the stream.
     *
     * @return self
     */
    public function __construct($content = null)
    {
        $this->StreamResource = fopen(static::FILENAME, static::MODE);
        if ($this->StreamResource !== false) {
            $this->Readable = true;
            $this->Writable = true;
            if (!empty($content)) {
                $this->Size = $this->write($content);
            }
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
            throw new \RuntimeException('Temporary stream is not writable');
        }

        $written = fwrite($this->StreamResource, $string);
        if ($written === false) {
            throw new \RuntimeException('Error writing to temporary stream');
        } else {
            $this->Size = null;
            return $written;
        }
    }
}
