<?php
namespace StoreCore\Admin;

class Installer extends \StoreCore\AbstractController
{
    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        // Run subsequent tests on success (true)
        if ($this->checkServerRequirements()) {
            if ($this->checkFileSystem()) {
                $this->checkDatabaseConnection();
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
        $dsn = STORECORE_DATABASE_DRIVER
            . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
            . ';charset=utf8';
        try {
            $dbh = new \PDO($dsn, STORECORE_DATABASE_USERNAME, STORECORE_DATABASE_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        } catch (\PDOException $e) {
            if ($this->Request->getRequestPath() !== '/admin/settings/database/') {
                $response = new \StoreCore\Response($this->Registry);
                $response->redirect('/admin/settings/database/');
            } else {
                $route = new \StoreCore\Route('/admin/settings/database/', '\StoreCore\Admin\SettingsDatabase');
                $route->dispatch();
            }
            return false;
        }
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
            return true;
        } else {
            $logger = new \StoreCore\FileSystem\Logger();
            foreach ($errors as $error) {
                $logger->critical($error);
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
            return true;
        } else {
            // Log critical conditions
            $logger = new \StoreCore\FileSystem\Logger();
            foreach ($errors as $error) {
                $logger->critical($error);
            }
            return false;
        }
    }
}
