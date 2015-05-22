<?php
namespace StoreCore\Database;

/**
 * Data Access Object (DAO)
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Database
 * @version   0.1.0
 */
abstract class AbstractDataAccessObject
{
    const VERSION = '0.1.0';

    /** @var StoreCore\Database\Connection $Connection */
    private $Connection;

    /**
     * Connect on construction.
     *
     * @param void
     * @return void
     */
    public function __construct()
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
        $sql = 'INSERT INTO ' . static::TABLE_NAME
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
     * @param mixed $value
     * @param string|null $key
     * @return int
     */
    public function delete($value, $key = null)
    {
        if ($key === null) {
            $key = static::PRIMARY_KEY;
        }

        if (!is_numeric($value)) {
            $value = $this->Connection->quote($value);
        }

        $sql = 'DELETE FROM ' . static::TABLE_NAME . ' WHERE ' . $key . '=' . $value;
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
        if ($key === null) {
            $key = static::PRIMARY_KEY;
        }

        if (!is_numeric($value)) {
            $value = $this->Connection->quote($value);
        }

        $sql = 'SELECT * FROM ' . static::TABLE_NAME . ' WHERE ' . $key . '=' . $value;

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
        $sql = 'UPDATE ' . static::TABLE_NAME . ' SET ';
        $updates = array();
        foreach ($keyed_data as $column => $value) {
            if (!is_numeric($value)) {
                $value = $this->Connection->quote($value);
            }
            $updates[] = $column . '=' . $value;
        }
        $sql .= implode(',', $updates);
        $sql .= ' WHERE ' . static::PRIMARY_KEY . '=' . $keyed_data[static::PRIMARY_KEY];

        $affected_rows = $this->Connection->exec($sql);
        return $affected_rows;
    }
}
