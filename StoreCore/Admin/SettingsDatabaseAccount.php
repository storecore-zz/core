<?php
namespace StoreCore\Admin;

use StoreCore\Admin\Document;
use StoreCore\Admin\Minifier;

use StoreCore\AbstractController;
use StoreCore\Registry;
use StoreCore\Response;
use StoreCore\View;

/**
 * Database Account Settings Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class SettingsDatabaseAccount extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '1.0.0';

    /**
     * @param \StoreCore\Registry $registry
     *
     * @return void
     *
     * @uses \PDO::getAvailableDrivers()
     * @uses \StoreCore\Request::getMethod()
     * @uses \StoreCore\ServerRequest::get()
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        if ($this->Request->getMethod() === 'POST') {
            $config = new Configurator();
            $save_config = false;

            // PDO database driver: currently skipped because only `mysql` is supported.
/*
            $driver = $this->Server->get('driver');
            if (
                $driver !== null
                && $driver !== STORECORE_DATABASE_DRIVER
                && in_array($driver, \PDO::getAvailableDrivers(), true) === true
            ) {
                $config->set('STORECORE_DATABASE_DRIVER', $driver);
                $save_config = true;
            }
 */

            // Database server host name or IP address
            $hostname = $this->Server->get('hostname');
            if ($hostname !== STORECORE_DATABASE_DEFAULT_HOST) {
                $config->set('STORECORE_DATABASE_DEFAULT_HOST', $hostname);
                $save_config = true;
            }

            // Database name
            $databasename = $this->Server->get('databasename');
            if ($databasename !== STORECORE_DATABASE_DEFAULT_DATABASE) {
                $config->set('STORECORE_DATABASE_DEFAULT_DATABASE', $databasename);
                $save_config = true;
            }

            // Database user account
            $username = $this->Server->get('username');
            if (is_string($username)) {
                $username = trim($username);
                if ($username !== STORECORE_DATABASE_DEFAULT_USERNAME && strlen($username) <= 16) {
                    $config->set('STORECORE_DATABASE_DEFAULT_USERNAME', $username);
                    $save_config = true;
                }
            }

            $password = $this->Server->get('password');
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

            $response = new Response($this->Registry);
            $response->redirect('/admin/settings/database/account/', 303);
        } else {
            $this->View = new \StoreCore\View();
            $this->View->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'SettingsDatabaseAccount.phtml');

            // Only select PDO drivers that are available in PHP as well as
            // supported by the StoreCore database.  Currently skipped because
            // only MySQL is supported.
/*
            $supported_drivers = array(
                'mysql' => 'MySQL (' . \StoreCore\I18N\ADJECTIVE_DEFAULT . ')',
            );
            $this->View->setValues(array('available_drivers' => \PDO::getAvailableDrivers()));
            $this->View->setValues(array('supported_drivers' => $supported_drivers));
 */

            $view = $this->View->render();
            $view = Minifier::minify($view);

            $document = new Document();
            $document->addSection($view, 'main');
            $response = new Response($registry);
            $response->setResponseBody($document);
            $response->output();
        }
    }
}
