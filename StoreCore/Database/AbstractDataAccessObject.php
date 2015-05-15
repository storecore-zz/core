<?php
namespace StoreCore\Database;

/**
 * Data Access Object (DAO)
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Database
 * @version   0.0.2
 */
abstract class AbstractDataAccessObject
{
    const VERSION = '0.0.2';


    /** @var object StoreCore\Database\Connection */
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
        $this->Connection = new \StoreCore\Database\Connection();
    }

    /**
     * Create a new database row.
     *
     * @param array $keyed_data
     * @return int
     */
    public function create(array $keyed_data)
    {
        $sql = 'INSERT INTO ' . $this->TableName
            . ' (' . implode(',', array_keys($keyed_data)) . ') VALUES (';
        $values = array_values($keyed_data);
        foreach ($values as $key => $value) {
            if (!is_numeric($value)) {
                $values[$key] = $this->Connection->quote($value);
            }
        }
        $sql .= implode(',', array_keys($values));
        $sql .= ')';

        $affected_rows = $this->Connection->exec($sql);
        return $affected_rows;
    }

    /**
     * Delete one or more database rows.
     *
     * @param string $value
     * @param string|null $key
     * @return int
     */
    public function delete($value, $key = null)
    {
        if ($key == null) {
            $key = $this->PrimaryKey;
        }

        if (!is_numeric($value)) {
            $value = $this->Connection->quote($value);
        }

        $sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $key . '=' . $value;
        $affected_rows = $this->Connection->exec($sql);
        return $affected_rows;
    }

    /**
     * Fetch one or more rows from a single database table.
     *
     * @param string $value
     * @param string|null $key
     * @return array
     */
    public function read($value, $key = null)
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
