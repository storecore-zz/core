<?php
namespace StoreCore\Database;

/**
 * StoreCore Database Backup
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Database
 * @version   0.1.0-alpha.1
 */
class Backup
{
    /** @var string VERSION */
    const VERSION = '0.1.0-alpha.1';

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
     * @return string
     *   Returns the filename of the SQL backup file.
     */
    public static function save($tables = '*', $drop_tables = false)
    {
        if (STORECORE_NULL_LOGGER) {
            $logger = new \Psr\Log\NullLogger();
        } else {
            $logger = new \StoreCore\FileSystem\Logger();
        }

        $mysqli = new \mysqli(
            STORECORE_DATABASE_DEFAULT_HOST,
            STORECORE_DATABASE_DEFAULT_USERNAME,
            STORECORE_DATABASE_DEFAULT_PASSWORD,
            STORECORE_DATABASE_DEFAULT_DATABASE
        );
        if ($mysqli->connect_error) {
            $logger->error('Connect error number ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error);
            exit;
        }
        $mysqli->set_charset('utf8');

        // Write pending changes to file.
        $result = $mysqli->query('FLUSH TABLES');

        // Fetch (all) tables
        if ($tables == '*') {
            $tables = array();
            $result = $mysqli->query('SHOW TABLES');
            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }
            $result->close();
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Cycle through all tables
        $sql_file_contents = (string)null;
        foreach ($tables as $table) {
            $sql = (string)null;
            $prepend = false;
            
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $num_fields = $result->field_count;

            // Add an optional DROP TABLE clause
            if ($drop_tables) {
                $sql .= 'DROP TABLE ' . $table . ";\n\n";
            }

            // Add CREATE TABLE IF NOT EXISTS clause
            $create_table_result = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $create_table_row = $create_table_result->fetch_row();
            $create_table = preg_replace('/CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_table_row[1], 1);
            $sql .= $create_table . ";\n\n";
            
            // Tables without foreign keys are prepended
            if (strpos($create_table, ' FOREIGN KEY ') === false) {
                $prepend = true;
            }

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = $result->fetch_row()) {
                    $sql .= 'INSERT IGNORE INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        if (isset($row[$j])) {
                            $sql.= '"' . $row[$j] . '"' ;
                        } else {
                            $sql.= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $sql.= ',';
                        }
                    }
                    $sql.= ");\n";
                }
            }
            $sql .= "\n\n";
            
            // Prepend or append
            if ($prepend) {
                $sql_file_contents = $sql . $sql_file_contents;
            } else {
                $sql_file_contents = $sql_file_contents . $sql;
            }
        }

        // Close database connection
        $mysqli->close();

        // Save SQL file
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'backup-' . date('Y-m-d-H-m-s') . '-UTC-' . time() . '.sql';
        $handle = fopen($filename, 'w+');
        fwrite($handle, $sql_file_contents);
        fclose($handle);

        $logger->notice('Database backup saved as ' . $filename . '.');
        return $filename;
    }
}
