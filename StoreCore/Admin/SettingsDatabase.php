<?php
namespace StoreCore\Admin;

class SettingsDatabase extends \StoreCore\AbstractController
{
    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        if ($this->Request->getMethod() === 'POST') {
            $config = new \StoreCore\Admin\Configurator();
            $save_config = false;

            // PDO database driver
            $driver = $this->Request->get('driver');
            if (
                $driver !== null
                && $driver !== STORECORE_DATABASE_DRIVER
                && in_array($driver, \PDO::getAvailableDrivers(), true) === true
            ) {
                $config->set('STORECORE_DATABASE_DRIVER', $driver);
                $save_config = true;
            }

            // Database server host name or IP address
            $hostname = $this->Request->get('hostname');
            if ($hostname !== STORECORE_DATABASE_DEFAULT_HOST) {
                $config->set('STORECORE_DATABASE_DEFAULT_HOST', $hostname);
                $save_config = true;
            }

            // Database name
            $databasename = $this->Request->get('databasename');
            if ($databasename !== STORECORE_DATABASE_DEFAULT_DATABASE) {
                $config->set('STORECORE_DATABASE_DEFAULT_DATABASE', $databasename);
                $save_config = true;
            }

            // Database user account
            $username = $this->Request->get('username');
            if (is_string($username)) {
                $username = trim($username);
                if ($username !== STORECORE_DATABASE_DEFAULT_USERNAME && strlen($username) <= 16) {
                    $config->set('STORECORE_DATABASE_DEFAULT_USERNAME', $username);
                    $save_config = true;
                }
            }

            $password = $this->Request->get('password');
            if ($password !== null) {
                $password = trim($password);
                if ($password !== STORECORE_DATABASE_DEFAULT_PASSWORD) {
                    $config->set('STORECORE_DATABASE_DEFAULT_PASSWORD', $password);
                    $save_config = true;
                }
            }

            // Save configuration changes
            if ($save_config) {
                $config->save();
                $logger = new \StoreCore\FileSystem\Logger();
                $logger->notice('Database configuration saved.');
            }

            $response = new \StoreCore\Response($this->Registry);
            $response->redirect('/admin/settings/database/', 303);
        } else {
            $this->View = new \StoreCore\View();
            $this->View->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'SettingsDatabase.phtml');

            // Only select PDO drivers that are available in PHP as well as
            // supported by the StoreCore\Database.
            $supported_drivers = array(
                'mysql' => 'MySQL (' . \StoreCore\I18N\ADJECTIVE_DEFAULT . ')',
            );
            $this->View->setValues(array('available_drivers' => \PDO::getAvailableDrivers()));
            $this->View->setValues(array('supported_drivers' => $supported_drivers));

            $view = $this->View->render();
            $view = \StoreCore\Admin\Minifier::minify($view);

            $document = new \StoreCore\Admin\Document();
            $document->addSection($view);
            $response = new \StoreCore\Response($registry);
            $response->setResponseBody($document);
            $response->output();
        }
    }
}
