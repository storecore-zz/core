<?php
namespace StoreCore\Admin;

class Installer extends \StoreCore\AbstractController
{
    /**
     * @var \StoreCore\FileSystem\Logger $Logger
     */
    private $Logger;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $this->Logger = new \StoreCore\FileSystem\Logger();

        // Run subsequent tests on success (true)
        if ($this->checkServerRequirements()) {
            if ($this->checkFileSystem()) {
                if ($this->checkDatabaseConnection()) {
                    $this->checkDatabaseStructure();
                }
            }
        }
    }

    /**
     * Check the database DSN and account.
     *
     * @param void
     * @return bool
     */
    private function checkDatabaseConnection()
    {
        try {
            $dbh = new \PDO($this->getDSN(), STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        } catch (\PDOException $e) {
            $this->Logger->critical($e->getMessage());
            if ($this->Request->getRequestPath() !== '/admin/settings/database/') {
                $response = new \StoreCore\Response($this->Registry);
                $response->redirect('/admin/settings/database/');
            } else {
                $route = new \StoreCore\Route('/admin/settings/database/', '\StoreCore\Admin\SettingsDatabase');
                $route->dispatch();
            }
            return false;
        }
        $dbh = null;
        $this->Logger->info('Database connection is good to go.');
        return true;
    }

    /**
     * Check the database structure.
     *
     * @param void
     * @return bool
     */
    private function checkDatabaseStructure()
    {
        try {
            $dbh = new \PDO($this->getDSN(), STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $this->Logger->debug('Database connection re-opened.');

            $tables = array();
            $stmt = $dbh->prepare('SHOW TABLES');
            if ($stmt->execute()) {
                while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
                    if (strpos($row[0], 'sc_', 0) === 0) {
                        $tables[] = $row[0];
                    }
                }
            }

            // Install all core tables
            if (count($tables) == 0) {
                $this->Logger->notice('No tables found: installing database.');
                $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 0);
                $sql = file_get_contents(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Database' . DIRECTORY_SEPARATOR . 'core-mysql.sql', false);
                $dbh->exec($sql);
                $sql = file_get_contents(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Database' . DIRECTORY_SEPARATOR . 'i18n-dml.sql', false);
                $dbh->exec($sql);
                $dbh = null;
            }

        } catch (\PDOException $e) {
            $this->Logger->critical($e->getMessage());
            return false;
        }
        $this->Logger->info('Database structure is good to go.');
        return true;
    }

    /**
     * Check files and folders.
     *
     * @param void
     * @return bool
     */
    private function checkFileSystem()
    {
        $errors = array();

        $files = array(
            STORECORE_FILESYSTEM_STOREFRONT_ROOT . 'config.php' => true,
            STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Database' . DIRECTORY_SEPARATOR . 'core-mysql.sql' => false,
            STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Database' . DIRECTORY_SEPARATOR . 'i18n-dml.sql' => false,
        );
        foreach ($files as $filename => $must_be_writable) {
            if (!is_file($filename)) {
                $errors[] = 'Bad or missing file: ' . $filename;
            } elseif ($must_be_writable && !is_writable($filename) ) {
                $errors[] = 'Wrong file permissions: ' . $filename . ' is not writable.';
            }
        }

        $folders = array(
            STORECORE_FILESYSTEM_CACHE => true,
            STORECORE_FILESYSTEM_LOGS => true,
        );
        foreach ($folders as $filename => $must_be_writable) {
            if (!is_dir($filename)) {
                $errors[] = 'Bad or missing directory: ' . $filename;
            } elseif ($must_be_writable) {
                if (!is_writable($filename)) {
                    $errors[] = 'Wrong directory permissions: ' . $filename . ' is not writable.';
                }
            }
        }

        if (count($errors) == 0) {
            $this->Logger->info('File system is good to go.');
            return true;
        } else {
            foreach ($errors as $error) {
                $this->Logger->critical($error);
            }
            return false;
        }
    }

    /**
     * Check if the current server meets the core requirements.
     *
     * @param void
     *
     * @return bool
     *     Returns true if the server meets all requirements, otherwise false.
     *     If a requirement is not met, the system error is logged to the file
     *     system as a critical condition.
     */
    private function checkServerRequirements()
    {
        $errors = array();

        if (version_compare(phpversion(), '5.3.0', '<')) {
            $errors[] = 'PHP version ' . phpversion() . ' is not supported.';
        }

        if (!extension_loaded('PDO')) {
            $errors[] = 'PHP extension PDO is not loaded.';
        }

        if (STORECORE_DATABASE_DRIVER === 'mysql' && !extension_loaded('pdo_mysql')) {
            $errors[] = 'PHP extension PDO for MySQL (pdo_mysql) is not loaded.';
        } elseif (!in_array(STORECORE_DATABASE_DRIVER, \PDO::getAvailableDrivers(), true)) {
            $errors[] = 'PDO driver ' . STORECORE_DATABASE_DRIVER . ' is not available.';
        }

        if (count($errors) == 0) {
            $this->Logger->info('Server configuration is good to go.');
            return true;
        } else {
            foreach ($errors as $error) {
                $this->Logger->critical($error);
            }
            return false;
        }
    }

    /**
     * Data Source Name (DSN)
     *
     * @param void
     * @return string
     */
    private function getDSN()
    {
        return STORECORE_DATABASE_DRIVER
            . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
            . ';charset=utf8';
    }
}
