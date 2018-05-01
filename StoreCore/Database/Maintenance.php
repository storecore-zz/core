<?php
namespace StoreCore\Database;

/**
 * Database Maintenance Module
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Maintenance extends \StoreCore\AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\Admin\Configurator|null $Configurator
     *   The admin configurator is used in the saveConfigurationSetting()
     *   method to write configuration settings to the global config.php
     *   configuration file.
     */
    private $Configurator;

    /**
     * @var array \ChangeLog
     *   Array with SQL statements that cannot be executed by parsing the
     *   default core SQL files.  Changes to database tables are ignored by the
     *   `IF NOT EXISTS` clause in a `CREATE TABLE IF NOT EXISTS`, so changes
     *   to tables and indexes should be moved elsewhere.
     */
    private $ChangeLog = array(

    );

    /**
     * @var bool $UpdateAvailable
     *   Boolean flag that indicates if a database update is available (true)
     *   or not (default false).
     */
    private $UpdateAvailable = false;

    /**
     * Database maintenance module constructor.
     *
     * The database maintenance module checks for updates as soon as it is
     * called (on construction) in two ways.  If the currently installed
     * database version is older than the version of this maintenance model,
     * an update is available.  If the database version is unknown, we assume
     * the database was never installed.
     *
     * @param \StoreCore\Registry $registry
     *   Single instance of the StoreCore registry.
     *
     * @return self
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        if (
            !defined('STORECORE_DATABASE_VERSION_INSTALLED')
            || version_compare(STORECORE_DATABASE_VERSION_INSTALLED, self::VERSION, '<')
        ) {
            $this->UpdateAvailable = true;
        }
    }

    /**
     * Delete records marked for removal after 30 days.
     *
     * @param int $interval_in_days
     *   Optional number of days records marked for deletion are kept in the
     *   recycle bin.  Defaults to 30 days.  The interval can be set to 0 (zero)
     *   to fully empty the recycle bin.
     *
     * @return int
     *   Returns the number of deleted database table rows.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$interval_in_days`
     *   parameter is not an integer.
     */
    public function emptyRecycleBin($interval_in_days = 30)
    {
        if (!is_int($interval_in_days)) {
            throw new \InvalidArgumentException();
        }

        if ($interval_in_days < 0) {
            $interval_in_days = 0;
        }

        $affected_rows = 0;
        $tables = array('sc_orders', 'sc_customers', 'sc_persons', 'sc_organizations', 'sc_addresses');
        foreach ($tables as $table) {
            $sql = 'DELETE FROM ' . $table . ' WHERE date_deleted IS NOT NULL';
            if ($interval_in_days !== 0) {
                $sql .= ' AND date_deleted < DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $interval_in_days . ' DAY)';
            }
            $affected_rows += $this->Database->exec($sql);
        }
        return $affected_rows;
    }

    /**
     * List the available SQL backup files.
     *
     * @param void
     *
     * @return array
     */
    public function getBackupFiles()
    {
        $files = array();

        if ($handle = opendir(__DIR__)) {
            while (false !== ($entry = readdir($handle))) {
                $pathinfo = pathinfo($entry);
                if (
                    array_key_exists('extension', $pathinfo)
                    && $pathinfo['extension'] == 'sql'
                    && strpos($entry, 'backup') !== false
                ) {
                    $realpath = realpath(__DIR__ . DIRECTORY_SEPARATOR . $entry);
                    $files[] = array(
                        'filename'  => $entry,
                        'filesize'  => filesize($realpath),
                        'filectime' => filectime($realpath),
                        'filemtime' => filemtime($realpath),
                    );
                }
            }
            closedir($handle);
        }

        return $files;
    }

    /**
     * Get all StoreCore database table names.
     *
     * @param void
     *
     * @return array
     *   Returns an indexed array with the names of all StoreCore database
     *   table.  Tables names for StoreCore always contain the `sc_` prefix;
     *   tables without this prefix are not included.
     */
    public function getTables()
    {
        $tables = array();
        $stmt = $this->Database->prepare('SHOW TABLES');
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
                if (strpos($row[0], 'sc_', 0) === 0) {
                    $tables[] = $row[0];
                }
            }
        }
        return $tables;
    }

    /**
     * Optimize tables.
     *
     * @param string|array|null $tables
     *   Optional comma-separated list or array of table names.
     *
     * @return void
     */
    public function optimize($tables = null)
    {
        if ($tables == null) {
            $tables = $this->getTables();
        }

        if (is_array($tables)) {
            $tables = implode(', ', $tables);
        }

        try {
            $this->Database->query('OPTIMIZE TABLE ' . $tables);
        } catch (\PDOException $e) {
            $this->Logger->notice($e->getMessage());
        }
    }

    /**
     * Restore the StoreCore database or a saved backup.
     *
     * @param string $filename
     *   Optional filename of a SQL backup file.
     *
     * @return bool
     *   Returns true on success or false on failures.
     */
    public function restore($filename = null)
    {
        // Write pending changes to database files
        try {
            $this->Database->exec('FLUSH TABLES');
        } catch (\PDOException $e) {
            $this->Logger->notice($e->getMessage());
        }

        try {
            // Update core tables using CREATE TABLE IF NOT EXISTS and INSERT IGNORE
            if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'core-mysql.sql')) {
                $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'core-mysql.sql', false);
                $this->Database->exec($sql);
            }

            // Add new translations using INSERT IGNORE
            if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'i18n-dml.sql')) {
                $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'i18n-dml.sql', false);
                $this->Database->exec($sql);
            }

            // Add optional SQL to restore a backup
            if ($filename !== null && is_file($filename)) {
                $sql = file_get_contents($filename, false);
                $this->Database->exec($sql);
            }

        } catch (\PDOException $e) {
            $this->Logger->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Save a configuration setting as a key/value pair.
     *
     * @param string $name
     *   Name of the configuration setting.
     *
     * @param string $value
     *   Value of the configuration setting.
     */
    private function saveConfigurationSetting($name, $value)
    {
        if ($this->Configurator == null) {
            $this->Configurator = new \StoreCore\Admin\Configurator();
        }
        $this->Configurator->set($name, $value);
        $this->Configurator->save();
    }

    /**
     * Update the StoreCore database.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function update()
    {
        try {
            // First restore the StoreCore default database
            $this->restore();

            // Execute other SQL statements
            foreach ($this->ChangeLog as $version => $sql) {
                if (version_compare($version, self::VERSION, '<=') == true) {
                    $this->Database->exec($sql);
                }
            }

            $this->saveConfigurationSetting('STORECORE_DATABASE_VERSION_INSTALLED', $version);
            $this->Logger->notice('StoreCore database version ' . self::VERSION . ' was installed.');

        } catch (\PDOException $e) {
            $this->Logger->error($e->getMessage());
            return false;
        }

        return true;
    }
}
