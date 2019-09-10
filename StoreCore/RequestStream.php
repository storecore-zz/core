<?php
namespace StoreCore;

use StoreCore\AbstractStream;
use Psr\Http\Message\StreamInterface;

/**
 * HTTP request stream message object.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class RequestStream extends AbstractStream implements StreamInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $Writable = false;

    /**
     * Create a client HTTP request stream.
     *
     * @param void
     * @return self
     */
    public function __construct()
    {
        $this->StreamResource = fopen('php://input', 'rb');
        if ($this->StreamResource === false) {
            $this->Readable = false;
        } else {
            $this->Readable = true;
            if (isset($_SERVER['CONTENT_LENGTH'])) {
                $this->Size = (int) $_SERVER['CONTENT_LENGTH'];
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        throw new \RuntimeException('Request input stream is immutable');
    }
}
