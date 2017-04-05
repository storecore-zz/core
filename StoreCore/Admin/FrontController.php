<?php
namespace StoreCore\Admin;

use \Psr\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Psr\Log\LoggerInterface as LoggerInterface;

use \StoreCore\AbstractController as AbstractController;
use \StoreCore\Admin\AccessControlWhitelist as AccessControlWhitelist;
use \StoreCore\Registry as Registry;
use \StoreCore\Response as Response;
use \StoreCore\Route as Route;
use \StoreCore\Database\RouteFactory as RouteFactory;
use \StoreCore\Session as Session;

/**
 * Administration Front Controller
 *
 * @author    Ward van der Put <ward.vanderput@storecore.org>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class FrontController extends AbstractController implements LoggerAwareInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @param \StoreCore\Registry $registry
     * @return self
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        // Run the installer on an incomplete installation.
        if (!defined('STORECORE_GUID')) {
            $this->install();
        }

        // Check the whitelist.
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

        // Find a matching route or route collection.
        $route = false;
        switch ($this->Request->getRequestPath()) {
            case '/admin/sign-out/':
                $route = new Route('/admin/sign-out/', '\StoreCore\Admin\User', 'signOut');
                break;
            default:
                $router = new RouteFactory($this->Registry);
                $route = $router->find($this->Request->getRequestPath());
                if ($route === null) {
                    $route = false;
                }
                break;
        }

        if ($route !== false) {
            $this->Registry->set('Route', $route);
            $route->dispatch();
        } else {
            $this->Logger->debug('Unknown admin route: ' . $this->Request->getRequestPath());
            $response = new Response($this->Registry);
            $response->addHeader('HTTP/1.1 404 Not Found');
            $response->output();
            exit;
        }
    }

    /**
     * Run the installer if the Installer.php class file exists.
     *
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
     * Set a logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *   PSR-3 “Logger Interface” compliant logger object.
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->Logger = $logger;
        $this->Registry->set('Logger', $this->Logger);
    }
}
