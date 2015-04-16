<?php
namespace StoreCore\Database;

class Maintenance
{
    /**
     * @var string VERSION
     *     Semantic version (SemVer).
     */
    const VERSION = '0.1.0-alpha';

    /**
     * @var \StoreCore\Admin\Configurator|null $Configurator
     */
    private $Configurator;

    /**
     * @var array \ChangeLog
     */
    private $ChangeLog = array(

    );

    /**
     * @var \StoreCore\Database\Connection|null $Connection
     */
    private $Connection;

    /**
     * @var array $InstalledTables
     */
    private $InstalledTables = array();

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        if (version_compare(STORECORE_DATABASE_INSTALLED, self::VERSION, '<') == true) {
            $this->update();
            $this->optimize();
        }
    }

    /**
     * Get all database table names.
     *
     * @api
     * @param void
     * @return array
     */
    public function getTables()
    {
        if ($this->Connection == null) {
            $this->Connection = new \StoreCore\Database\Connection();
        }

        $tables = array();
        $stmt = $this->Connection->prepare('SHOW TABLES');
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
                if (strpos($row[0], 'sc_', 0) === 0) {
                    $tables[] = $row[0];
                }
            }
        }

        $this->InstalledTables = $tables;
        return $tables;
    }

    /**
     * Optimize tables.
     *
     * @param string|null $tables
     *     Optional comma-separated list of table names.
     *
     * @return mixed
     */
    public function optimize($tables = null)
    {
        if ($tables == null) {
            $tables = implode(', ', $this->InstalledTables);
        }

        if ($this->Connection == null) {
            $this->Connection = new \StoreCore\Database\Connection();
        }
        return $this->Connection->query('OPTIMIZE TABLE ' . $tables);
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
     * @internal
     * @param void
     * @param return bool
     */
    private function update()
    {
        $logger = new \StoreCore\FileSystem\Logger();

        try {
            $this->Connection = new \StoreCore\Database\Connection();
            $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

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

            // Execute other SQL statements
            foreach ($this->ChangeLog as $version => $sql) {
                if (version_compare($version, self::VERSION, '<=') == true) {
                    $this->Connection->exec($sql);
                }
            }

            $this->saveConfigurationSetting('STORECORE_DATABASE_INSTALLED', $version);
            $logger->notice('StoreCore database version ' . self::VERSION . ' was installed.');

        } catch (\PDOException $e) {
            $logger = new \StoreCore\FileSystem\Logger();
            $logger->error($e->getMessage());
            return false;
        }

        return true;
    }
}
