<?php
namespace StoreCore\Database;

/**
 * Data Access Object (DAO)
  *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore\Database
 * @version   0.0.1
 */
abstract class AbstractDataAccessObject
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /** @type object PDO */
    private $Connection;

    /**
     * Connect on construction.
     *
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
        $dsn = STORECORE_DATABASE_DRIVER . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST;
        try {
            $this->Connection = new \PDO($dsn, STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD);
        } catch (\PDOException $e) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->error('Database connection failed: ' . trim($e->getMessage()));

            // Reconnect after a few seconds to balance heavy loads
            $seconds = mt_rand(2, 5);
            $logger->notice('Reconnecting in ' . $seconds . ' seconds.');
            sleep($seconds);
            try {
                $this->Connection = new \PDO($dsn, STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD);
            } catch (\PDOException $e) {
                $logger->critical('Service unavailable: ' . trim($e->getMessage()));
                if (!headers_sent()) {
                    header('HTTP/1.1 503 Service Unavailable', true, 503);
                    header('Retry-After: 60');
                }
                exit;
            }
        }
    }
 
    /**
     * Fetch one or more rows from a single database table.
     *
     * @param string $value
     * @param string|null $key
     * @return array
     */
    public function fetch($value, $key = null)
    {
        if ($key == null) {
            $key = $this->PrimaryKey;
        }

        $sql = 'SELECT * FROM ' . $this->TableName . ' WHERE ' . $key . ' = ';
        if (is_int($value)) {
            $sql .= $value;
        } else {
            $sql .= $this->Connection->quote($value);
        }

        $rows = array();
        $stmt = $this->Connection->query($sql);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    } 
}
