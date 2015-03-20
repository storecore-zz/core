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
    private $Connection;
    
    public function __construct()
    {
        $this->connect();
    }
    
    private function connect()
    {
        $dsn = STORECORE_DATABASE_DRIVER . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST;
        try {
            $this->Connection = new \PDO($dsn, STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD);
        } catch (\PDOException $e) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->error('Connection failed: ' . $e->getMessage());
        }
    }
 
    public function fetch($value, $key = null)
    {
        if ($key == null) {
            $key = $this->PrimaryKey;
        }

        $sql = 'SELECT * FROM ' . $this->TableName . ' WHERE ' . $key . '=';
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
