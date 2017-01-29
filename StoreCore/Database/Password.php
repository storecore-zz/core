<?php
namespace StoreCore\Database;

/**
 * Password
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class Password
{
    const VERSION = '0.1.0';

    /**
     * @var string DEFAULT_ALGORITHM
     *   Default password hashing algorithm that is used if it is supported
     *   on systems where the PHP crypt() function supports multiple hash
     *   types.  This constant MUST be reset if an algorithm becomes obsolete.
     */
    const DEFAULT_ALGORITHM = 'Blowfish';

    /**
     * @var int WORK_FACTOR_BLOWFISH
     * @var int WORK_FACTOR_SHA512
     */
    const WORK_FACTOR_BLOWFISH = 15;
    const WORK_FACTOR_SHA512 = 1000000;

    /**
     * @var string $Algorithm
     * @var string|null $Hash
     * @var string|null $Password
     * @var string|null $Salt
     */
    private $Algorithm;
    private $Hash;
    private $Password;
    private $Salt;

    /**
     * @param string|null $password
     * @param string|null $salt
     * @return void
     * @uses \StoreCore\Database\Password::setPassword()
     * @uses \StoreCore\Database\Password::setSalt()
     */
    public function __construct($password = null, $salt = null)
    {
        if ($password !== null) {
            $this->setPassword($password);
            if ($salt !== null) {
                $this->setSalt($salt);
            }
        }
    }

    /**
     * Get the password hash string.
     *
     * @param void
     * @return string
     */
    public function __toString()
    {
        $this->Password = null;
        return ($this->Hash === null) ? '' : $this->getHash();
    }

    /**
     * Encrypt the password.
     *
     * Encrypt the password to a hash string using the Blowfish or SHA-512
     * algorithm.  If these algorithms are not supported, hashing will first
     * fall back to Standard DES and then to SHA-1.
     *
     * @param string|null $password
     *   Optional password.
     *
     * @param string|null $salt
     *   Optional salt.  If no salt is set, a random salt is used.
     *
     * @return float
     *   Returns the time elapsed in seconds, accurate to the nearest
     *   microsecond.  This return value may be used to balance the work
     *   factors.
     *
     * @throws BadMethodCallException
     */
    public function encrypt($password = null, $salt = null)
    {
        $time_start = microtime(true);

        if ($password !== null) {
            $this->setPassword($password);
        } elseif ($this->Password === null) {
            throw new \BadMethodCallException('Missing argument: ' . __METHOD__ . ' expects parameter 1 to be a password string.');
        }

        if ($salt !== null) {
            $this->setSalt($salt);
        }

        if (version_compare(PHP_VERSION, '5.3.7', '>=') && CRYPT_BLOWFISH == 1) {

            $this->Algorithm = 'Blowfish';
            if ($this->Salt === null || strlen($this->Salt) !== 22) {
                $this->Salt = \StoreCore\Database\Salt::getInstance(22);
            }
            $salt = '$2y$' . self::WORK_FACTOR_BLOWFISH . '$' . $this->Salt . '$';
            $this->Hash = crypt($this->Password, $salt);

        } elseif (version_compare(PHP_VERSION, '5.3.2', '>=') && CRYPT_SHA512 == 1) {

            $this->Algorithm = 'SHA-512';
            if ($this->Salt === null || strlen($this->Salt) !== 16) {
                $this->Salt = \StoreCore\Database\Salt::getInstance(16);
            }
            $salt = '$6$rounds=' . self::WORK_FACTOR_SHA512 . '$' . $this->Salt . '$';
            $this->Hash = crypt($this->Password, $salt);

        } elseif (CRYPT_STD_DES == 1) {

            $this->Algorithm = 'Standard DES';
            if ($this->Salt === null || strlen($this->Salt) !== 2) {
                $this->Salt = \StoreCore\Database\Salt::getInstance(2);
            }
            $this->Hash = crypt($this->Password, $this->Salt);

        } else {

            $this->Algorithm = 'SHA-1';
            $this->Salt = \StoreCore\Database\Salt::getInstance();
            $this->Hash = sha1($this->Salt . $this->Password);

        }

        return microtime(true) - $time_start;
    }

    /**
     * @param void
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->Algorithm;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getHash()
    {
        return $this->Hash;
    }

    /**
     * @param void
     * @return string
     */
    public function getSalt()
    {
        return $this->Salt;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->Password = $password;
    }

    /**
     * Add salt to the password.
     *
     * @param string $salt
     * @return void
     */
    public function setSalt($salt)
    {
        $this->Salt = $salt;
    }
}
