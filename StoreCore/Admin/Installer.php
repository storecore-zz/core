<?php
namespace StoreCore\Admin;

/**
 * StoreCore Installer
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class Installer extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0-alpha.1';

    /** @var \StoreCore\FileSystem\Logger $Logger */
    protected $Logger;

    /** @var bool $SelfDestruct */
    private $SelfDestruct = false;

    /**
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

                            if ($this->moveConfigurationFiles()) {
                                $this->SelfDestruct = true;
                            }

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
     * @param void
     * @return void
     */
    public function __destruct()
    {
        if (true === $this->SelfDestruct) {
            if (true === unlink(__FILE__)) {
                $this->Logger->notice('Deleted the StoreCore installer file ' . __FILE__ . '.');
            } else {
                $this->Logger->notice('Could not delete the StoreCore installer file ' . __FILE__ . '.');
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
        $this->Logger->info('Database connection is set up correctly.');
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
                $this->Logger->notice('No database tables found: installing StoreCore database.');
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
        $this->Logger->info('Database structure is set up correctly.');
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
            } elseif ($must_be_writable && !is_writable($filename)) {
                $errors[] = 'Wrong file permissions: ' . $filename . ' is not writable.';
            }
        }

        $folders = array(
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'css'  => true,
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'ico'  => false,
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'jpeg' => true,
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'png'  => true,
            \StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'svg'  => false,
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
            $this->Logger->info('File system is set up correctly.');
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
            $this->Logger->info('Web server configuration is set up correctly.');
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
            $this->Logger->info('User accounts are set up correctly.');
            return true;
        }

        $this->Logger->warning('No active user accounts were found: adding a new user with administrator privileges.');
        unset($users);

        if ($this->Request->getRequestMethod() == 'POST') {

            $user = new \StoreCore\User();
            $user->setUserGroupID(254);

            // First name and last name
            if ($this->Request->get('first_name') !== null) {
                $user->setFirstName($this->Request->get('first_name'));
            }
            if ($this->Request->get('last_name') !== null) {
                $user->setLastName($this->Request->get('last_name'));
            }

            // E-mail address
            if ($this->Request->get('email_address') !== null) {
                try {
                    $email_address = new \StoreCore\Types\EmailAddress($this->Request->get('email_address'));
                    $user->setEmailAddress($email_address);
                } catch (\Exception $e) {
                    $this->Logger->warning('Invalid e-mail address: ' . $this->Request->get('email_address'));
                }
            }
            
            // Personal identification number (optional, defaults to '0000')
            if ($this->Request->get('pin_code') !== null) {
                $pin_code = trim($this->Request->get('pin_code'));
                if ( 
                    is_numeric($pin_code)
                    && strlen($pin_code) >= 4
                    && strlen($pin_code) <= 6
                ) {
                    $user->setPIN($pin_code);
                }
                unset($pin_code);
            }

            // Username
            if (is_string($this->Request->get('username'))) {
                $username = trim($this->Request->get('username'));
                if (!empty($username)) {
                    $user->setUsername($username);
                }
            }

            // Set an omitted username to the user's first name.
            if ($user->getUsername() === null && $user->getFirstName() !== null) {
                $user->setUsername($user->getFirstName());
            }

            // Password
            if (
                $user->getEmailAddress() !== null
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
                $user->setPasswordSalt($password->getSalt());
                $user->setHashAlgorithm($password->getAlgorithm());
                $user->setPasswordHash($password->getHash());
                unset($password);
            }

            // Insert user
            if (in_array(false, $user_data, true) !== true) {
                try {
                    $dbh = new \StoreCore\Database\Connection();
                    $stmt = $dbh->prepare('
                        INSERT INTO sc_users
                             (user_group_id, password_reset, password_salt, hash_algo, username, password_hash, first_name, last_name, email_address, pin_code)
                           VALUES
                             (254, UTC_TIMESTAMP(), :password_salt, :hash_algo, :username, :password_hash, :first_name, :last_name, :email_address, :pin_code)
                    ');
                    $stmt->bindParam(':password_salt', $user_data['password_salt']);
                    $stmt->bindParam(':hash_algo',     $user_data['hash_algo']);
                    $stmt->bindParam(':username',      $user_data['username']);
                    $stmt->bindParam(':password_hash', $user_data['password_hash']);
                    $stmt->bindParam(':first_name',    $user_data['first_name']);
                    $stmt->bindParam(':last_name',     $user_data['last_name']);
                    $stmt->bindParam(':email_address', $user_data['email_address']);
                    $stmt->bindParam(':pin_code',      $user_data['pin_code']);
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

    /**
     * Move config.php out of the root.
     *
     * @param void
     * @return bool
     */
    private function moveConfigurationFiles()
    {
        $root_parent_directory = realpath(\StoreCore\FileSystem\STOREFRONT_ROOT_DIR . '../');
        if (!is_dir($root_parent_directory) || !is_writable($root_parent_directory)) {
            $this->Logger->notice('The directory ' . $root_parent_directory . ' is inaccessible.');
            return false;
        }

        $root_parent_directory .= DIRECTORY_SEPARATOR;

        $renamed_config_php = false;
        if (is_file(\StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'config.php')) {
            $renamed_config_php = rename(\StoreCore\FileSystem\STOREFRONT_ROOT_DIR . 'config.php', $root_parent_directory . 'config.php');
            if ($renamed_config_php) {
                $this->Logger->notice('Moved configuration file config.php to: ' . $root_parent_directory . 'config.php');
            }
        }

        if ($renamed_config_php) {
            return true;
        } else {
            return false;
        }
    }
}
