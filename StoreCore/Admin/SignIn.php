<?php
namespace StoreCore\Admin;

use \StoreCore\Response as Response;

/**
 * Administration Sign-In
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class SignIn extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

    /**
     * @var string $Token
     *   Handshake token that links a specific form to a specific session.
     */
    private $Token;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        if ($this->Request->getMethod() == 'GET') {
            $this->resetToken();
            $this->render();
            exit;
        } elseif ($this->Request->getMethod() != 'POST') {
            $this->resetToken();
            header('Allow: GET, POST');
            header('HTTP/1.1 405 Method Not Allowed', true);
            $this->Logger->warning('HTTP/1.1 405 Method Not Allowed');
            exit;
        }

        if (
            !is_string($this->Request->get('username'))
            || !is_string($this->Request->get('password'))
            || !is_string($this->Request->get('token'))
        ) {
            $response = new Response($this->Registry);
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Audit failed and successful attempts
        $login_audit = new \StoreCore\Database\LoginAudit($this->Registry);

        // HTTP response object
        $response = new Response($this->Registry);

        // Token handshake
        if ($this->Request->get('token') != $this->Session->get('Token')) {
            $this->Logger->notice('Token mismatch in admin sign-in.');
            $this->resetToken();
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Check recent failed attempts
        $minutes = 15;
        $failed_attempts = $login_audit->count($minutes);
        if ($failed_attempts > 10) {
            $this->Logger->warning('There were over ' . $failed_attempts . ' failed admin sign-in attempts in the last ' . $minutes . ' minutes.');
        }

        // Connection throttling: pause for 2 ^ n seconds.
        // Maximum execution is set to the PHP default minus 5 seconds.
        $seconds = pow(2, (int)($failed_attempts / 10));
        $max_execution_time = (int)ini_get('max_execution_time') - 5;
        if ($seconds > $max_execution_time) {
            $seconds = $max_execution_time;
        }
        sleep($seconds);

        // Try to fetch the user.
        $user_mapper = new \StoreCore\Database\UserMapper($this->Registry);
        $user = $user_mapper->getUserByUsername($this->Request->get('username'));
        if ($user === null) {
            $this->Logger->warning('Unknown user "' . $this->Request->get('username') . '" attempted to sign in.');
            $login_audit->storeAttempt($this->Request->get('username'));
            $this->resetToken();
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Check the user password.
        if ($user->authenticate($this->Request->get('password')) !== true) {
            $this->Logger->warning(
                'Known user "' . $user->getUsername() . '" (#' .
                $user->getUserID() . ') attempted to sign in with an illegal password.'
            );
            $login_audit->storeAttempt($this->Request->get('username'));
            $this->resetToken();
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Finally, store the user and open up the administration.
        $this->Logger->notice('User "' . $user->getUsername() . '" (#' . getUserID() . ') signed in.');
        $login_audit->storeAttempt($this->Request->get('username'), null, true);
        $this->Session->set('User', $user);
        $response->redirect('/admin/', 303);
        exit;
    }

    /**
     * @param void
     * @return string
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param void
     * @return void
     */
    private function render()
    {
        $view = new \StoreCore\View();
        $view->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'SignIn.phtml');
        $view->setValues(array('token' => $this->getToken()));
        $view = $view->render();

        $document = new \StoreCore\Admin\Document();
        $document->addSection($view);
        $document->setTitle(\StoreCore\I18N\COMMAND_SIGN_IN);

        /*
         * After 1 minute (60000 milliseconds) the current window times out,
         * JavaScript then redirects the client to the lock screen.
         */
        $document->addScript("window.setTimeout(function() { top.location.href = '/admin/lock/'; }, 60000);");

        $document = \StoreCore\Admin\Minifier::minify($document);

        $response = new Response($this->Registry);
        $response->addHeader('Allow: GET, POST');
        $response->setResponseBody($document);
        $response->output();
    }

    /**
     * @param void
     * @return void
     */
    private function resetToken()
    {
        $this->Token = \StoreCore\Types\FormToken::getInstance();
        $this->Session->set('Token', $this->Token);
    }
}
