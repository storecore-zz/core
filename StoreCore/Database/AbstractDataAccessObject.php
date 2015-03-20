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
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST . ';charset=utf8';

        try {
            $this->Connection = new \PDO($dsn, STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD);
            if (version_compare(PHP_VERSION, '5.3.6', '<') {
                $this->Connection->exec('SET NAMES utf8');
            }
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

        if (!is_numeric($value)) {
            $value = $this->Connection->quote($value);
        }
        $sql = 'SELECT * FROM ' . $this->TableName . ' WHERE ' . $key . '=' . $value;

        $rows = array();
        $stmt = $this->Connection->query($sql);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Update a single database row.
     *
     * @param array $keyed_data
     * @return int
     */
    public function update(array $keyed_data)
    {
        $sql = 'UPDATE ' . $this->TableName . ' SET ';            
        $updates = array();
        foreach ($keyed_data as $column => $value) {
            if (!is_numeric($value)) {
                $value = $this->Connection->quote($value);
            }
            $updates[] = $column . '=' . $value;
        }
        $sql .= implode(',', $updates);
        $sql .= ' WHERE ' . $this->PrimaryKey . '=' . $keyed_data[$this->PrimaryKey];

        $affected_rows = $this->Connection->exec($sql);
        return $affected_rows;
    }
}
