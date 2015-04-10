<?php
namespace StoreCore\Admin;

use \Psr\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Psr\Log\LoggerInterface as LoggerInterface;

use \StoreCore\AbstractController as AbstractController;
use \StoreCore\FileSystem\Logger as Logger;

class FrontController extends AbstractController implements LoggerAwareInterface
{
    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $this->setLogger(new Logger());
        $this->Logger->debug('Admin front controller loaded.');

        if ($this->Registry->has('Session') === false) {
            $this->Registry->set('Session', new \StoreCore\Session());
        }

        if ($this->Session->get('Language') === null) {
            $this->setLanguage();
        }
        include STORECORE_FILESYSTEM_CACHE . 'data' . DIRECTORY_SEPARATOR . $this->Session->get('Language') . '.php';
    }

    /**
     * @param void
     * @return void
     */
    public function install()
    {
        $this->Logger->notice('Installer loaded');
        $route = new \StoreCore\Route('/install/', '\StoreCore\Admin\Installer');
        $route->dispatch();
    }

    /**
     * @param void
     * @return void
     */
    private function setLanguage()
    {
        $supported_languages = array(
            'de-DE' => true,
            'en-GB' => true,
            'fr-FR' => true,
            'nl-NL' => true,
        );

        $gtld = call_user_func('end', array_values(explode('.', $this->Request->getHostName())));
        switch ($gtld) {
            case 'de':
                $default_language = 'de-DE';
                break;
            case 'nl':
                $default_language = 'nl-NL';
                break;
            default:
                $default_language = 'en-GB';
        }

        $content_negotiator = new \StoreCore\I18N\Language();
        $language = $content_negotiator->negotiate($supported_languages, $default_language);
        $this->Session->set('Language', $language);
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
