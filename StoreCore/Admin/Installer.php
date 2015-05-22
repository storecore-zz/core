<?php
namespace StoreCore\Admin;

/**
 * StoreCore Installer
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Installer extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\FileSystem\Logger $Logger
     */
    protected $Logger;

    /**
     * @api
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        // Log to the file system (and never to a null logger)
        $this->Logger = new \StoreCore\FileSystem\Logger();
        $this->Registry->set('Logger', $this->Logger);
        
        // Set multibyte character encoding to UTF-8
        mb_internal_encoding('UTF-8');

        // Run subsequent tests on success (true)
        if ($this->checkServerRequirements()) {
            if ($this->checkFileSystem()) {
                if ($this->checkDatabaseConnection()) {
                    if ($this->checkDatabaseStructure()) {
                        if ($this->checkUsers()) {
                            $config = new \StoreCore\Admin\Configurator();
                            $config->set('StoreCore\\VERSION_INSTALLED', \StoreCore\VERSION);
                            $config->save();
                            $this->Logger->notice('Completed installation of StoreCore version ' . \StoreCore\VERSION . '.');

                            $response = new \StoreCore\Response($this->Registry);
                            $response->redirect('/admin/sign-in/');
                            exit;
                        }
                    }
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
            $dbh = new \PDO($this->getDSN(), \StoreCore\Database\DEFAULT_USERNAME, \StoreCore\Database\DEFAULT_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
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
            $maintenance_module = new \StoreCore\Database\Maintenance($this->Registry);
            $tables = $maintenance_module->getTables();

            // Install all core tables
            if (count($tables) == 0) {
                $this->Logger->notice('No tables found: installing database.');
                $maintenance_module->restore();

                $config = new \StoreCore\Admin\Configurator();
                $config->set('StoreCore\\Database\\VERSION_INSTALLED', \StoreCore\VERSION);
                $config->save();
                $this->Logger->notice('StoreCore database version ' . \StoreCore\VERSION . ' was installed.');
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
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'config.php' => true,
            \StoreCore\FileSystem\CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'de-DE.php' => true,
            \StoreCore\FileSystem\CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'en-GB.php' => true,
            \StoreCore\FileSystem\CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'fr-FR.php' => true,
            \StoreCore\FileSystem\CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'nl-NL.php' => true,
            \StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'core-mysql.sql' => false,
            \StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'i18n-dml.sql' => false,
        );
        foreach ($files as $filename => $must_be_writable) {
            if (!is_file($filename)) {
                $errors[] = 'Bad or missing file: ' . $filename;
            } elseif ($must_be_writable && !is_writable($filename) ) {
                $errors[] = 'Wrong file permissions: ' . $filename . ' is not writable.';
            }
        }

        $folders = array(
            \StoreCore\FileSystem\CACHE_DIR => true,
            \StoreCore\FileSystem\LOGS_DIR => true,
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
     *   Returns true if the server meets all requirements, otherwise false.
     *   If a requirement is not met, the system error is logged to the file
     *   system as a critical condition.
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

        if (\StoreCore\Database\DRIVER === 'mysql' && !extension_loaded('pdo_mysql')) {
            $errors[] = 'PHP extension PDO for MySQL (pdo_mysql) is not loaded.';
        } elseif (!in_array(\StoreCore\Database\DRIVER, \PDO::getAvailableDrivers(), true)) {
            $errors[] = 'PDO driver ' . \StoreCore\Database\DRIVER . ' is not available.';
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
     * Check for user account(s).
     *
     * @param void
     * @return bool
     */
    private function checkUsers()
    {
        $users = new \StoreCore\Database\Users($this->Registry);
        if ($users->count() !== 0) {
            $this->Logger->info('User accounts are good to go.');
            return true;
        }

        $this->Logger->warning('No active user accounts found: adding new user.');
        unset($users);

        $user_data = array(
            'password_salt' => false,
            'hash_algo'     => false,
            'username'      => false,
            'password_hash' => false,
            'first_name'    => false,
            'last_name'     => false,
            'email_address' => false,
        );

        if ($this->Request->getRequestMethod() == 'POST') {
            // First name and last name
            if ($this->Request->get('first_name') !== null) {
                $user_data['first_name'] = $this->Request->get('first_name');
            }
            if ($this->Request->get('last_name') !== null) {
                $user_data['last_name'] = $this->Request->get('last_name');
            }

            // E-mail address
            if ($this->Request->get('email_address') !== null) {
                try {
                    $email_address = new \StoreCore\Types\EmailAddress($this->Request->get('email_address'));
                    $user_data['email_address'] = (string)$email_address;
                } catch (\Exception $e) {
                    $this->Logger->warning('Invalid e-mail address:' . $this->Request->get('email_address'));
                    $user_data['email_address'] = false;
                }
            }

            // Username
            if (is_string($this->Request->get('username'))) {
                $username = trim($this->Request->get('username'));
                if (!empty($username)) {
                    $user_data['username'] = $username;
                }
            }

            // Set omitted username to "someone" in "someone@example.com"
            if ($user_data['username'] === false && $user_data['email_address'] !== false) {
                $email_address = explode('@', $user_data['email_address']);
                $user_data['username'] = $email_address[0];
                unset($email_address);
            }
            
            // Password
            if (
                $user_data['email_address'] !== false
                && is_string($this->Request->get('password'))
                && is_string($this->Request->get('confirm_password'))
                && $this->Request->get('password') == $this->Request->get('confirm_password')
                && mb_stristr($this->Request->get('password'), $user_data['username']) === false
                && \StoreCore\Admin\PasswordCompliance::validate($this->Request->get('password')) === true
                && \StoreCore\Database\CommonPassword::exists($this->Request->get('password')) === false
            ) {
                $password = new \StoreCore\Database\Password();
                $password->setPassword($this->Request->get('password'));
                $password->encrypt();
                $user_data['password_salt'] = $password->getSalt();
                $user_data['hash_algo']     = $password->getAlgorithm();
                $user_data['password_hash'] = $password->getHash();
                unset($password);
            }

            // Insert user
            if (in_array(false, $user_data, true) !== true) {
                try {
                    $dbh = new \StoreCore\Database\Connection();
                    $stmt = $dbh->prepare('
                        INSERT INTO sc_users
                             (user_group_id, password_reset, password_salt, hash_algo, username, password_hash, first_name, last_name, email_address)
                           VALUES
                             (254, UTC_TIMESTAMP(), :password_salt, :hash_algo, :username, :password_hash, :first_name, :last_name, :email_address)
                    ');
                    $stmt->bindParam(':password_salt', $user_data['password_salt']);
                    $stmt->bindParam(':hash_algo',     $user_data['hash_algo']);
                    $stmt->bindParam(':username',      $user_data['username']);
                    $stmt->bindParam(':password_hash', $user_data['password_hash']);
                    $stmt->bindParam(':first_name',    $user_data['first_name']);
                    $stmt->bindParam(':last_name',     $user_data['last_name']);
                    $stmt->bindParam(':email_address', $user_data['email_address']);
                    $success = $stmt->execute();
                } catch (\PDOException $e) {
                    $this->Logger->critical($e->getMessage());
                    return false;
                }

                if ($success == true) {
                    $this->Logger->notice('User account created for: ' . $user_data['first_name'] . ' ' . $user_data['last_name'] . '.');
                    return true;
                }
            }
        }

        // Create a view to add an account
        foreach ($user_data as $name => $value) {
            if ($value === false) {
                $user_data[$name] = '';
            }
        }

        $view = new \StoreCore\View();
        $view->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'User.phtml');
        $view->setValues($user_data);

        $form = $view->render();
        $form = \StoreCore\Admin\Minifier::minify($form);

        $document = new \StoreCore\Admin\Document();
        $document->addSection($form);
        $response = new \StoreCore\Response($this->Registry);
        $response->setResponseBody($document);
        $response->output();

        $this->Logger->info('Displaying user account form.');
        return false;
    }

    /**
     * Data Source Name (DSN)
     *
     * @param void
     * @return string
     */
    private function getDSN()
    {
        return \StoreCore\Database\DRIVER
            . ':dbname=' . \StoreCore\Database\DEFAULT_DATABASE
            . ';host=' . \StoreCore\Database\DEFAULT_HOST
            . ';charset=utf8';
    }
}
