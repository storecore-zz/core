<?php
namespace StoreCore\Admin;

use \Psr\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Psr\Log\LoggerInterface as LoggerInterface;

use \StoreCore\AbstractController as AbstractController;
use \StoreCore\Admin\AccessControlWhitelist as AccessControlWhitelist;
use \StoreCore\Registry as Registry;
use \StoreCore\Response as Response;
use \StoreCore\Route as Route;
use \StoreCore\Session as Session;

/**
 * Administration Front Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class FrontController extends AbstractController implements LoggerAwareInterface
{
    const VERSION = '0.1.0';

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        if (!defined('STORECORE_VERSION_INSTALLED')) {
            $this->install();
        }

        // Check the whitelist
        $whitelist = new AccessControlWhitelist($this->Registry);
        $whitelist->check();

        // Check if there is a user signed in.
        if ($this->Session->has('User')) {
            $this->User = $this->Session->get('User');
        } else {
            $response = new Response($registry);
            $response->redirect('/admin/sign-in/');
            exit;
        }
    }

    /**
     * @param void
     * @return void
     */
    public function install()
    {
        if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'Installer.php')) {
            $this->Logger->warning('Installer loaded.');
            $route = new Route('/install/', '\StoreCore\Admin\Installer');
            $route->dispatch();
        } else {
            $this->Logger->notice('StoreCore core class file Installer.php not found.');
        }
        exit;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->Logger = $logger;
        $this->Registry->set('Logger', $this->Logger);
    }
}
