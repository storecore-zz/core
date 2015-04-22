<?php
namespace StoreCore\Database;

class Maintenance extends \StoreCore\AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic version (SemVer).
     */
    const VERSION = '0.1.0-alpha';

    /**
     * @var \StoreCore\Admin\Configurator|null $Configurator
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
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        /*
         * If the currently installed database version is older than this
         * maintenance module, an update is available.
         */
        if (
            !defined('StoreCore\\Database\\VERSION_INSTALLED')
            || version_compare(\StoreCore\Database\VERSION_INSTALLED, self::VERSION, '<')
        ) {
            $this->UpdateAvailable = true;
        }
        
        // Use a fresh connection that does not emulate prepared statements.
        $this->Connection = new \StoreCore\Database\Connection();
        $this->Connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * List the available SQL backup files.
     *
     * @api
     * @param void
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
     * @api
     * @param void
     * @return array
     */
    public function getTables()
    {
        $tables = array();
        $stmt = $this->Connection->prepare('SHOW TABLES');
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
     * @param string|null $tables
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

        $this->Connection->query('OPTIMIZE TABLE ' . $tables);
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
        try {
            // Write pending changes to database files
            $this->Connection->exec('FLUSH TABLES');
            
            // Update core tables using CREATE TABLE IF NOT EXISTS and INSERT IGNORE
            if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'core-mysql.sql')) {
                $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'core-mysql.sql', false);
                $this->Connection->exec($sql);
            }

            // Add new translations using INSERT IGNORE
            if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'i18n-dml.sql')) {
                $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'i18n-dml.sql', false);
                $this->Connection->exec($sql);
            }
            
            // Add optional SQL to restore a backup
            if ($filename !== null && is_file($filename)) {
                $sql = file_get_contents($filename, false);
                $this->Connection->exec($sql);
            }

        } catch (\PDOException $e) {
            $logger->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @internal
     * @param string $name
     * @param string $value
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
     * Update the database.
     *
     * @api
     * @param void
     * @return bool
     */
    public function update()
    {
        // Ignore a null logger
        $logger = new \StoreCore\FileSystem\Logger();

        try {
            // First restore the StoreCore default database
            $this->restore();

            // Execute other SQL statements
            foreach ($this->ChangeLog as $version => $sql) {
                if (version_compare($version, self::VERSION, '<=') == true) {
                    $this->Connection->exec($sql);
                }
            }

            $this->saveConfigurationSetting('StoreCore\\Database\\VERSION_INSTALLED', $version);
            $logger->notice('StoreCore database version ' . self::VERSION . ' was installed.');

        } catch (\PDOException $e) {
            $logger->error($e->getMessage());
            return false;
        }

        return true;
    }
}
