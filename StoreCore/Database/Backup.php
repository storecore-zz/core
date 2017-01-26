<?php
namespace StoreCore\Database;

/**
 * StoreCore Database Backup
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @todo
 *   Because the `SHOW TABLES` command lists database tables in alphabetical
 *   order, the recovery of a full backup may fail on chained `FOREIGN KEY`
 *   constraints.  Depending on the database structure and the selected
 *   tables, you MAY have to manually change the order of the `CREATE TABLE`
 *   statements.
 */
class Backup
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Save a database backup to file.
     *
     * @param string|array $tables
     *   Optional comma-separated string or array with the names of database
     *   tables to save.  Defaults to '*' for all tables.
     *
     * @param bool $drop_tables
     *   If set to true, `DROP TABLE <tbl_name>` clauses are added to delete
     *   existing database tables.  Defaults to false, so only non-existent
     *   database tables are recreated with the `CREATE TABLE IF NOT EXISTS`
     *   clause.
     *
     * @return string|false
     *   Returns the filename of the SQL backup file on success or false on
     *   failure.
     */
    public static function save($tables = '*', $drop_tables = false)
    {
        // Get or create a logger.
        $registry = \StoreCore\Registry::getInstance();
        if ($registry->has('Logger')) {
            $logger = $registry->get('Logger');
        } elseif (STORECORE_NULL_LOGGER) {
            $logger = new \Psr\Log\NullLogger();
        } else {
            $logger = new \StoreCore\FileSystem\Logger();
        }

        // Connect to the database with a new client.
        try {
            $dbh = new \StoreCore\Database\Connection();
        } catch (\PDOException $e) {
            $logger->error('Database connection error ' . $e->getCode() . ': ' . $e->getMessage());
            return false;
        }

        // Fetch (all) tables
        if ($tables == '*') {
            try {
                $result = $dbh->query('SHOW TABLES');
                if ($result === false) {
                    return false;
                } else {
                    $tables = array();
                    foreach ($result as $row) {
                        $tables[] = $row[0];
                    }
                }
                $result->closeCursor();
            } catch (\PDOException $e) {
                $logger->error('Database error ' . $e->getCode() . ' showing tables: ' . $e->getMessage());
                return false;
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Write pending changes to file.
        try {
            $dbh->exec('FLUSH TABLES');
        } catch (\PDOException $e) {
            $logger->notice('Error ' . $e->getCode() . ' flushing tables: ' . $e->getMessage());
        }

        // Cycle through all tables
        try {
            $sql_file_contents = (string)null;
            foreach ($tables as $table_name) {
                $sql = (string)null;
                $prepend = false;

                // Add an optional DROP TABLE clause.
                if ($drop_tables) {
                    $sql .= 'DROP TABLE ' . $table_name . ";\n\n";
                }

                // Add the CREATE TABLE IF NOT EXISTS clause.
                $result = $dbh->query('SHOW CREATE TABLE ' . $table_name);
                $create_table_row = $result->fetch(\PDO::FETCH_NUM);
                $create_table = preg_replace('/CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_table_row[1], 1);
                $sql .= $create_table . ";\n\n";

                // Tables without foreign keys are prepended.
                if (strpos($create_table, ' FOREIGN KEY ') === false) {
                    $prepend = true;
                }

                // Add the table data from a non-empty table.
                $result = $dbh->query('SELECT COUNT(*) FROM ' . $table_name);
                if ($result->fetchColumn() > 0) {
                    $result = $dbh->query('SELECT * FROM ' . $table_name);
                    $sql .= 'INSERT IGNORE INTO ' . $table_name . ' VALUES';
                    while ($row = $result->fetch(\PDO::FETCH_NUM)) {
                        foreach ($row as $key => $value) {
                            if (is_string($value)) {
                                $row[$key] = "'" . addslashes($value) . "'";
                            }
                        }
                        $sql .= "\n  (" . implode(',', $row) . '),';
                    }
                    $sql = rtrim($sql, ',') . ";\n\n";
                }

                // Prepend or append
                if ($prepend) {
                    $sql_file_contents = $sql . $sql_file_contents;
                } else {
                    $sql_file_contents = $sql_file_contents . $sql;
                }
            }
        } catch (\PDOException $e) {
            $logger->error('Database error ' . $e->getCode() . ': ' . $e->getMessage());
            return false;
        }

        // Disconnect
        try {
            $result->closeCursor();
            $dbh = null;
            unset($result, $dbh);
        } catch (\PDOException $e) {
            $logger->notice('Error ' . $e->getCode() . ' flushing tables: ' . $e->getMessage());
        }

        // Save SQL file
        if (defined('STORECORE_FILESYSTEM_CACHE_DIR')) {
            $dir = STORECORE_FILESYSTEM_CACHE_DIR;
        } else {
            $dir = __DIR__ . DIRECTORY_SEPARATOR;
        }
        $filename = $dir . 'backup-' . gmdate('Y-m-d-H-m-s') . '-UTC.sql';
        $handle = fopen($filename, 'w+');
        if ($handle !== false) {
            fwrite($handle, $sql_file_contents);
            fclose($handle);
            $logger->notice('Database backup saved as ' . $filename . '.');
            return $filename;
        } else {
            $logger->error('Could not create database backup file.');
            return false;
        }
    }
}
