<?php
namespace StoreCore\Types;

/**
 * Shopping Cart Identifier
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class CartID
{
    const VERSION = '0.1.0';

    /**
     * @var array $CartID
     *   Indexed array consisting of a Semantic Versioning (SemVer) version ID
     *   (index 0), a universally unique identifier or UUID (index 1), and a
     *   random token string (index 2).
     */
    private $CartID;

    /**
     * @param string|null $uuid
     * @param string|null $token
     * @return void
     */
    public function __construct($uuid = null, $token = null)
    {
        $this->CartID = array(0 => self::VERSION);
        $this->setUUID($uuid);
        $this->setToken($token);
    }

    /**
     * @param void
     * @return string
     * @uses \StoreCore\Types\CartID::encode()
     */
    public function __toString()
    {
        return $this->encode();
    }

    /**
     * Decode a Base64 and JSON encoded string to a shopping cart ID.
     *
     * @param string $from_string
     *
     * @return bool
     *   Returns true on success, otherwise false.
     */
    public function decode($from_string)
    {
        if (!is_string($from_string) || empty($from_string)) {
            return false;
        }

        $from_string = base64_decode($from_string);
        $data = json_decode($from_string, true, 2);
        if (!is_array($data) || count($data) !== 3) {
            return false;
        }

        if (array_key_exists(0, $data) && version_compare($data[0], self::VERSION, '<=')) {
            $this->CartID[0] = $data[0];
        } else {
            return false;
        }

        if (array_key_exists(1, $data) && array_key_exists(2, $data)) {
            try {
                $this->setUUID($data[1]);
                $this->setToken($data[2]);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the shopping cart ID as a MIME Base64 and JSON encoded string.
     *
     * @param void
     * @return string
     */
    public function encode()
    {
        $cart_id = json_encode($this->CartID);
        $cart_id = base64_encode($cart_id);
        return $cart_id;
    }

    /**
     * Get the shopping cart UUID.
     *
     * @param void
     * @return string
     */
    public function getUUID()
    {
        return $this->CartID[1];
    }

    /**
     * Get the shopping cart ID token.
     *
     * @param void
     * @return string
     */
    public function getToken()
    {
        return $this->CartID[2];
    }

    /**
     * Regenerate the random shopping cart token.
     *
     * @param void
     * @return void
     */
    public function resetToken()
    {
        $this->CartID[2]
            = base_convert(bin2hex(openssl_random_pseudo_bytes(128)), 16, 36)
            . base_convert(bin2hex(openssl_random_pseudo_bytes(128)), 16, 36)
            . base_convert(bin2hex(openssl_random_pseudo_bytes(128)), 16, 36);
    }

    /**
     * Generate a random UUID.
     *
     * A new UUID or GUID should be generated with a database function like
     * UUID() in MySQL when a cart is added to the database.  This method
     * mimics the structure of a UUID string using the PHP functions uniqid()
     * and openssl_random_pseudo_bytes() to allow for setting and resetting the
     * UUID without a database connection.
     *
     * @param void
     * @return void
     */
    private function resetUUID()
    {
        $uniqid = uniqid(null, true);
        $uniqid = explode('.', $uniqid);
        $uniqid[1] = dechex($uniqid[1]);
        $uniqid = implode(null, $uniqid);
        $uniqid .= bin2hex(openssl_random_pseudo_bytes(6));
        $this->CartID[1]
            = substr($uniqid, 0, 8) . '-' . substr($uniqid, 8, 4) . '-'
            . substr($uniqid, 12, 4) . '-' . substr($uniqid, 16, 4) . '-'
            . substr($uniqid, 20, 12);
    }

    /**
     * Set or reset the shopping cart token.
     *
     * @param string|null $token
     * @return void
     */
    public function setToken($token = null)
    {
        if ($token === null) {
            $this->resetToken();
        } else {
            $this->CartID[2] = $token;
        }
    }

    /**
     * Set the shopping cart UUID.
     *
     * @param string|null $uuid
     * @return void
     *
     * @throws \UnexpectedValueException
     *   An SPL (Standard PHP Library) unexpected value runtime exception is
     *   thrown if the UUID is not a string consisting of 36 lowercase ASCII
     *   characters.
     */
    public function setUUID($uuid = null)
    {
        if ($uuid === null) {
            $this->resetUUID();
        } elseif (
            !is_string($uuid)
            || strlen($uuid) !== 36
            || mb_detect_encoding($uuid, 'ASCII', true) !== 'ASCII'
            || substr_count($uuid, '-') !== 4
        ) {
            throw new \UnexpectedValueException();
        } else {
            $this->CartID[1] = $uuid;
        }
    }
}
