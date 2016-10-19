<?php
namespace StoreCore\Admin;

/**
 * StoreCore Installer
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Installer extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

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
                            $config->set('STORECORE_VERSION_INSTALLED', STORECORE_VERSION);
                            $config->set('STORECORE_MAINTENANCE_MODE', true);
                            $config->save();
                            $this->Logger->notice('Completed installation of StoreCore version ' . STORECORE_VERSION . '.');

                            $this->SelfDestruct = true;

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
            $dbh = new \PDO($this->getDSN(), STORECORE_DATABASE_DEFAULT_USERNAME, STORECORE_DATABASE_DEFAULT_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
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
                $config->set('STORECORE_DATABASE_VERSION_INSTALLED', STORECORE_VERSION);
                $config->save();
                $this->Logger->notice('StoreCore database version ' . STORECORE_VERSION . ' was installed.');
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

        $folders = array(
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'css'  => true,
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'ico'  => false,
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'jpeg' => true,
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'png'  => true,
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR . 'svg'  => false,
            STORECORE_FILESYSTEM_CACHE_DIR => true,
            STORECORE_FILESYSTEM_LOGS_DIR => true,
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

        $files = array(
            STORECORE_FILESYSTEM_STOREFRONT_ROOT_DIR . 'config.php' => true,
            STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'de-DE.php' => true,
            STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'en-GB.php' => true,
            STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'fr-FR.php' => true,
            STORECORE_FILESYSTEM_CACHE_DIR . 'data' . DIRECTORY_SEPARATOR . 'nl-NL.php' => true,
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'core-mysql.sql' => false,
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'i18n-dml.sql' => false,
        );
        foreach ($files as $filename => $must_be_writable) {
            if (!is_file($filename)) {
                $errors[] = 'Bad or missing file: ' . $filename;
            } elseif ($must_be_writable && !is_writable($filename)) {
                $errors[] = 'Wrong file permissions: ' . $filename . ' is not writable.';
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

        if (STORECORE_DATABASE_DRIVER === 'mysql' && !extension_loaded('pdo_mysql')) {
            $errors[] = 'PHP extension PDO for MySQL (pdo_mysql) is not loaded.';
        } elseif (!in_array(STORECORE_DATABASE_DRIVER, \PDO::getAvailableDrivers(), true)) {
            $errors[] = 'PDO driver ' . STORECORE_DATABASE_DRIVER . ' is not available.';
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

        unset($users);
        $this->Logger->warning('No active user accounts were found: adding a new user with administrator privileges.');

        $user = new \StoreCore\User();
        $user->setUserGroupID(254);
        $user_data = array(
            'first_name' => false,
            'last_name' => false,
            'email_address' => false,
            'username' => false,
            'pin_code' => '0000',
        );

        if ($this->Request->getMethod() == 'POST') {

            // First name and last name
            if ($this->Request->get('first_name') !== null) {
                $user->setFirstName($this->Request->get('first_name'));
                $user_data['first_name'] = $user->getFirstName();
            }
            if ($this->Request->get('last_name') !== null) {
                $user->setLastName($this->Request->get('last_name'));
                $user_data['last_name'] = $user->getLastName();
            }

            // E-mail address
            if ($this->Request->get('email_address') !== null) {
                try {
                    $email_address = new \StoreCore\Types\EmailAddress($this->Request->get('email_address'));
                    $user->setEmailAddress($email_address);
                    $user_data['email_address'] = $user->getEmailAddress();
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
                    $user_data['pin_code'] = $user->getPIN();
                }
                unset($pin_code);
            }

            // Username
            if (is_string($this->Request->get('username'))) {
                $username = trim($this->Request->get('username'));
                if (!empty($username)) {
                    $user->setUsername($username);
                    $user_data['username'] = $user->getUsername();
                }
            }

            // Set an omitted username to the user's first name.
            if ($user->getUsername() === null && $user->getFirstName() !== null) {
                $user->setUsername($user->getFirstName());
                $user_data['username'] = $user->getUsername();
            }

            // Password
            $user_has_password = false;
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
                $user_has_password = true;
            }

            // Insert user
            if ($user_has_password && !in_array(false, $user_data, true)) {
                try {
                    $user_mapper = new \StoreCore\Database\UserMapper($this->Registry);
                    $user_mapper->save($user);
                    $this->Logger->notice('User account created for: ' . $user->getFullName());
                    return true;
                } catch (\Exception $e) {
                    $this->Logger->critical($e->getMessage());
                }
            }
        }

        // Try to find a known administrator or general e-mail address
        if ($user_data['email_address'] === false) {
            if (isset($_SERVER['SERVER_ADMIN']) && !empty($_SERVER['SERVER_ADMIN'])) {
                $email_address = filter_var($_SERVER['SERVER_ADMIN'], FILTER_SANITIZE_EMAIL);
                if (filter_var($email_address, FILTER_VALIDATE_EMAIL) !== false) {
                    $user_data['email_address'] = $email_address;
                }
            }
        }
        if ($user_data['email_address'] === false) {
            $email_address = ini_get('sendmail_from');
            if ($email_address !== false && !empty($email_address)) {
                $email_address = filter_var($email_address, FILTER_SANITIZE_EMAIL);
                if (filter_var($email_address, FILTER_VALIDATE_EMAIL) !== false) {
                    $user_data['email_address'] = $email_address;
                }
            }
        }

        // Create a view to add an account
        foreach ($user_data as $name => $value) {
            if ($value === false || $value === null) {
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
        return STORECORE_DATABASE_DRIVER
            . ':dbname=' . STORECORE_DATABASE_DEFAULT_DATABASE
            . ';host=' . STORECORE_DATABASE_DEFAULT_HOST
            . ';charset=utf8';
    }
}
