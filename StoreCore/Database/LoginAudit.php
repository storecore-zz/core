<?php
namespace StoreCore\Database;

class LoginAudit implements \Countable
{
    /**
     * @param void
     * @return void
     * @uses \StoreCore\Database\Connection()::__construct()
     */
    public function __construct()
    {
        // Open a fresh connection
        $this->Connection = new \StoreCore\Database\Connection();
        // Do not emulate prepares but use true prepared statements
        $this->Connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Count the total number of stored attempts.
     *
     * @param void
     * @return int
     */
    public function count()
    {
        $sql = 'SELECT COUNT(*) FROM sc_login_attempts';
        $result = $this->Connection->query($sql);
        $row = $result->fetch(\PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * Count the recently failed login attempts.
     *
     * @api
     *
     * @param int $minutes
     *     Size of the time frame in minutes, defaults to 15 minutes.
     *
     * @return int
     */
    public function countLastFailedAttempts($minutes = 15)
    {
        $minutes = (int)abs($minutes);
        $sql = 'SELECT COUNT(*) FROM sc_login_attempts WHERE successful = 0 AND attempted > DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $minutes . ' MINUTE)';
        $result = $this->Connection->query($sql);
        $row = $result->fetch(\PDO::FETCH_NUM);
        return $row[0];
    }

    /**
     * Store a login attempt.
     *
     * @api
     *
     * @param string|null $username
     *     Username or some other user identifier of the user logging in.  The
     *     username may be set to an e-mail address, or to an empty string if
     *     the username is unknown.
     *
     * @param string|null $remote_address
     *     Remote client IP address.
     *
     * @param bool $successful
     *     The login attempt was successful (true) or failed (false).  This
     *     parameter MUST explicitly be set to a boolean true in order to log
     *     a successful attempt.
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

        $sql = "INSERT INTO sc_login_attempts (successful, attempted, remote_address, username) VALUES (:successful, UTC_TIMESTAMP(), :remote_address, :username)";
        $stmt = $this->Connection->prepare($sql);

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
