<?php
namespace StoreCore\Types;

/**
 * Abstract generic CHAR data object.
 *
 * The only distinction between a CHAR and a VARCHAR in the extended parent
 * class \StoreCore\Types\Varchar is a fixed string length.  Classes that
 * extend this abstract AbstractChar class SHOULD implement a check of the
 * required string length for a given data object type.  If strict typing is
 * enabled, this class will throw a domain logic exception assuming that a
 * fixed length can never by 0.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
abstract class AbstractChar extends Varchar implements TypeInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * @inheritDoc
     */
    public function __construct($initial_value, $strict = true)
    {
        if ($strict && empty($initial_value)) {
            throw new \DomainException();
        }
        parent::__construct($initial_value, $strict);
    }
}
