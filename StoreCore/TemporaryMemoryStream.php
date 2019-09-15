<?php
namespace StoreCore;

use \Psr\Http\Message\StreamInterface;
use \StoreCore\TemporaryStream;

/**
 * Temporary memory stream.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class TemporaryMemoryStream extends TemporaryStream implements StreamInterface
{
    /**
     * @var string FILENAME
     *   The default value `php://memory` for this class and the overwritten
     *   parent value `php://temp` both are read-write streams that allow
     *   temporary data to be stored in a file-like wrapper.  The only
     *   difference between the two is that `php://memory` implemented in this
     *   class will always store its data in memory, whereas `php://temp` in
     *   the parent class will use a temporary file once the amount of data
     *   stored hits a predefined limit.  The default memory limit is 2 MB.
     */
    const FILENAME = 'php://memory';

    /**
     * @inheritDoc
     */
    const MODE = 'r+';

    /**
     * @inheritDoc
     */
    const VERSION = '1.0.0';
}
