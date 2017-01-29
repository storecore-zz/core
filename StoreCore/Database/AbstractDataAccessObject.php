<?php
namespace StoreCore\Database;

/**
 * Data Access Object (DAO)
 *
 * The StoreCore abstract DAO provides a CRUD interface to Create, Read,
 * Update, and Delete database records.   It executes the four basic SQL data
 * manipulation operations: INSERT, SELECT, UPDATE, and DELETE.  Model classes
 * that extend the abstract DAO MUST provide two class constants for late
 * static bindings: a TABLE_NAME with the database table name the model
 * operates on and a PRIMARY_KEY for the primary key column of this table.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
abstract class AbstractDataAccessObject extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * Create a new database row.
     *
     * @param array $keyed_data
     *   Associative array with the structure of a single database record.  The
     *   array keys MUST match column names in the database table.
     *
     * @return int|false
     *   Returns the primary key of the inserted row on success or false on
     *   failure.  Usually the primary key is then used as the unique ID of an
     *   object.
     */
    public function create(array $keyed_data)
    {
        // Remove all NULL values on an INSERT.
        $keyed_data = array_filter($keyed_data, function($var){return ($var !== null);});

        $columns = array_keys($keyed_data);
        $sql = 'INSERT INTO ' . static::TABLE_NAME . ' (' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns) . ')';

        try {
            $stmt = $this->Connection->prepare($sql);
            unset($columns, $sql);

            foreach ($keyed_data as $key => $value) {
                // Store booleans as a TINYINT 1 for true or 0 for false.
                if (is_bool($value)) {
                    if ($value === true) {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }

                $key = ':' . $key;
                if (is_int($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                } elseif (is_string($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($key, strval($value), \PDO::PARAM_STR);
                }
            }

            if ($stmt->execute()) {
                $stmt->closeCursor();
                return $this->Connection->lastInsertId();
            } else {
                return false;
            }

        } catch (\PDOException $e) {

            return false;

        }
    }

    /**
     * Delete one or more database rows.
     *
     * @param mixed $value
     *
     * @param string|int|null $key
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function delete($value, $key = null)
    {
        if ($key === null) {
            $key = static::PRIMARY_KEY;
        }

        $sql = 'DELETE FROM ' . static::TABLE_NAME;
        if ($value === null) {
            $sql .= ' WHERE ' . $key . ' IS NULL';
        } else {
            $sql .= ' WHERE ' . $key . ' = :' . $key;
        }

        try {
            $stmt = $this->Connection->prepare($sql);
            if ($value !== null) {
                $key = ':' . $key;
                if (is_int($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                } elseif (is_string($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($key, strval($value), \PDO::PARAM_STR);
                }
            }
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Fetch one or more rows from a single database table.
     *
     * @param mixed $value
     *   Value to search for in the $key column.
     *
     * @param string|int $key
     *   Optional name of a column in the static::TABLE_NAME database table.
     *   If omitted, the column for the primary key in static::PRIMARY_KEY is
     *   used.
     *
     * @return array|false
     *   Returns an array on success or false on failure.  The array MAY be
     *   empty if the query was executed without any errors but no matching
     *   database records were found.
     */
    public function read($value, $key = null)
    {
        if ($key === null) {
            $key = static::PRIMARY_KEY;
        }

        $sql = 'SELECT * FROM ' . static::TABLE_NAME;
        if ($value === null) {
            $sql .= ' WHERE ' . $key . ' IS NULL';
        } else {
            $sql .= ' WHERE ' . $key . ' = :' . $key;
        }

        try {
            $stmt = $this->Connection->prepare($sql);
            if ($value !== null) {
                $key = ':' . $key;
                if (is_int($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                } elseif (is_string($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($key, strval($value), \PDO::PARAM_STR);
                }
            }
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $stmt->closeCursor();
                return $result;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Update one or more database rows.
     *
     * @param array $keyed_data
     *
     * @param string $where_clause
     *   Optional SQL WHERE clause for additional conditions.  This clause
     *   MUST NOT contain the WHERE keyword.  If this WHERE clause is omitted,
     *   the UPDATE is limitted to a single record.
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function update(array $keyed_data, $where_clause = null)
    {
        // Limit UPDATE to a single row if no WHERE clause is provided.
        if ($where_clause === null) {
            $where_clause = ' WHERE ' . static::PRIMARY_KEY . '=' . $keyed_data[static::PRIMARY_KEY];
        } else {
            $where_clause = ' WHERE ' . trim($where_clause);
        }

        // Never UPDATE the primary key.
        unset($keyed_data[static::PRIMARY_KEY]);

        $updates = array();
        foreach ($keyed_data as $key => $value) {
            if (is_bool($value)) {
                if ($value === true) {
                    $value = 1;
                } else {
                    $value = 0;
                }
            }
            $updates[] = $key . ' = :' . $key;
        }
        $sql = 'UPDATE ' . static::TABLE_NAME . ' SET ' . implode(', ', $updates) . $where_clause;

        try {
            $stmt = $this->Connection->prepare($sql);
            foreach ($keyed_data as $key => $value) {
                $key = ':' . $key;
                if (is_null($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_NULL);
                } elseif (is_int($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                } elseif (is_string($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($key, strval($value), \PDO::PARAM_STR);
                }
            }
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
