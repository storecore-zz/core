<?php
namespace StoreCore\Database;

class Users implements \Countable
{
    /**
     * @var string VERSION
     */
    const VERSION = '0.0.1';

    /**
     * @var object StoreCore\Database\Connection
     */
    private $Connection;

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Connect to the database.
     *
     * @param void
     * @return void
     */
    private function connect()
    {
        $this->Connection = new \StoreCore\Database\Connection();
    }

    /**
     * Count the number of active users.
     *
     * @param void
     *
     * @return int
     *     User accounts may be disabled, permanently or temporarily, by
     *     setting the user group ID to 0 (zero).  This method therefore
     *     returns a count of all users from different user groups
     *     (WHERE user_group_id != 0).
     */
    public function count()
    {
        $sql = 'SELECT SQL_NO_CACHE COUNT(*) FROM sc_users WHERE user_group_id != 0';
        $stmt = $this->Connection->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        return $row[0];
    }
}
