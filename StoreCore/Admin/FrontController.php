<?php
namespace StoreCore\Admin;

use \Psr\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Psr\Log\LoggerInterface as LoggerInterface;

use \StoreCore\AbstractController as AbstractController;
use \StoreCore\Registry as Registry;
use \StoreCore\Route as Route;
use \StoreCore\Session as Session;

use \StoreCore\FileSystem\Logger as Logger;
use \StoreCore\I18N\Locale as Locale;

class FrontController extends AbstractController implements LoggerAwareInterface
{
    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        $this->setLogger(new Logger());

        if ($this->Registry->has('Session') === false) {
            $this->Registry->set('Session', new Session());
        }
    }

    /**
     * @param void
     * @return void
     */
    public function install()
    {
        $this->Logger->notice('Installer loaded.');
        $route = new Route('/install/', '\StoreCore\Admin\Installer');
        $route->dispatch();
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
