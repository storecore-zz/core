<?php
namespace StoreCore\Database;

/**
 * Login Audit
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 *
 * @internal
 * @method int count ( [ int $minutes = 15 ] )
 * @method void storeAttempt ( [ string $username [, string $remote_address [, bool $successful = false ]]] )
 */
class LoginAudit extends AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * Count the recently failed login attempts.
     *
     * @param int $minutes
     *   Size of the time frame in minutes, defaults to 15 minutes.
     *
     * @return int
     */
    public function count($minutes = 15)
    {
        if (!is_numeric($minutes)) {
            throw new \InvalidArgumentException();
        }
        $minutes = (int)abs($minutes);

        $stmt = $this->Connection->prepare('SELECT COUNT(*) FROM sc_login_attempts WHERE successful = 0 AND attempted > DATE_SUB(UTC_TIMESTAMP(), INTERVAL :minutes MINUTE)');
        $stmt->bindValue(':minutes', $minutes, \PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return (int)$count;
    }

    /**
     * Store a login attempt.
     *
     * @param string|null $username
     *   Username or some other user identifier of the user logging in.  The
     *   username may be set to an e-mail address or to an empty string if
     *   the username is unknown.
     *
     * @param string|null $remote_address
     *   Remote client IP address.
     *
     * @param bool $successful
     *   The login attempt was successful (true) or failed (false).  This
     *   parameter MUST explicitly be set to a boolean true in order to log
     *   a successful attempt.
     *
     * @return void
     */
    public function storeAttempt($username = null, $remote_address = null, $successful = false)
    {
        if ($username !== null) {
            $username = trim($username);
            if (empty($username)) {
                $username = null;
            }
        }

        if ($remote_address === null) {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $remote_address = $_SERVER['REMOTE_ADDR'];
            }
        }

        if ($successful === true) {
            $successful = 1;
        } else {
            $successful = 0;
        }

        $stmt = $this->Connection->prepare('INSERT INTO sc_login_attempts (successful, attempted, remote_address, username) VALUES (:successful, UTC_TIMESTAMP(), :remote_address, :username)');

        $stmt->bindParam(':successful', $successful, \PDO::PARAM_INT);

        if ($username == null) {
            $stmt->bindParam(':username', $username, \PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        }

        if (is_string($remote_address)) {
            $stmt->bindParam(':remote_address', $remote_address, \PDO::PARAM_STR);
        } else {
            $stmt->bindParam(':remote_address', $remote_address, \PDO::PARAM_NULL);
        }

        $stmt->execute();
    }
}
