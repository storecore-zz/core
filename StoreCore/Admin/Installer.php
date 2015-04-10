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

        if ($this->checkServerRequirements()) {
            $this->checkDatabaseConnection();
        }

    }

    /**
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
                $route = new \StoreCore\Route('/admin/settings/database/', '\Admin\SettingsDatabase');
                $route->dispatch();
            }
        }
    }

    /**
     * @param void
     * @return bool
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
            return false;
        }
    }
}
