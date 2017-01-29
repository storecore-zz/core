<?php
namespace StoreCore\Types;

/**
 * UUID version 4 client ID.
 *
 * This class provides an RFC 4122 compliant version 4 UUID (universally
 * unique identifier) for unique client ID's.  This ID is used as the
 * required `cid` tracking parameter in the Google Measurement Protocol.
 * The client ID may be stored as a CHAR(36) database value and is generally
 * stored as a first-party cookie with a two-year expiration.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   1.0.0
 *
 * @see https://www.ietf.org/rfc/rfc4122.txt
 *      A Universally Unique IDentifier (UUID) URN Namespace (RFC 4122)
 *
 * @see https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cid
 *      Client ID in the Google Measurement Protocol Parameter Reference
 */
class ClientID extends AbstractChar implements TypeInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * @param string|null $initial value
     *   UUID v4 string.  If the initial value is explicitly set to null
     *   or to an empty string, a new random UUID is generated.
     *
     * @param bool $strict
     *   Enforce strict typing (default true) or loose typing (false).
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument runtime exception if strict typing is
     *   enforced and the $initial_value parameter is not a string.
     *
     * @throws \DomainException
     *   A domain exception is thrown of the initial value is not 36 characters
     *   long or does not contain four hyphens.
     */
    public function __construct($initial_value, $strict = true)
    {
        if ($initial_value === null || empty($initial_value)) {
            $initial_value = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }

        if (
            strlen($initial_value) !== 36
            || substr_count($initial_value, '-') !== 4
        ) {
            throw new \DomainException();
        }

        parent::__construct($initial_value, $strict);
    }
}
