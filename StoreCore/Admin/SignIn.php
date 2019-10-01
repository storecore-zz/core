<?php
namespace StoreCore\Admin;

use StoreCore\AbstractController;
use StoreCore\Registry;
use StoreCore\ResponseFactory;
use StoreCore\View;

use StoreCore\Admin\Document;
use StoreCore\Admin\Minifier;

use StoreCore\Database\LoginAudit;
use StoreCore\Database\UserMapper;

use StoreCore\Types\FormToken;

/**
 * Administration Sign-In
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   0.1.0
 */
class SignIn extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string $Token
     *   Handshake token that links a specific form to a specific session.
     */
    private $Token;

    /**
     * @param \StoreCore\Registry $registry
     *
     * @return void
     *
     * @uses \StoreCore\Request::getMethod()
     * @uses \StoreCore\ServerRequest::get()
     * @uses \StoreCore\Database\LoginAudit::storeAttempt()
     */
    public function __construct(Registry $registry)
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
            !is_string($this->Server->get('username'))
            || !is_string($this->Server->get('password'))
            || !is_string($this->Server->get('token'))
        ) {
            $factory = new ResponseFactory();
            $response = $factory->createResponse(303);
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Audit failed and successful attempts
        $login_audit = new LoginAudit($this->Registry);

        // HTTP response object
        $factory = new ResponseFactory();
        $response = $factory->createResponse();

        // Token handshake
        if ($this->Server->get('token') != $this->Session->get('Token')) {
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
        $user_mapper = new UserMapper($this->Registry);
        $user = $user_mapper->getUserByUsername($this->Server->get('username'));
        if ($user === null) {
            $this->Logger->warning('Unknown user "' . $this->Server->get('username') . '" attempted to sign in.');
            $login_audit->storeAttempt($this->Server->get('username'));
            $this->resetToken();
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Check the user password.
        if ($user->authenticate($this->Server->get('password')) !== true) {
            $this->Logger->warning(
                'Known user "' . $user->getUsername() . '" (#' .
                $user->getUserID() . ') attempted to sign in with an illegal password.'
            );
            $login_audit->storeAttempt($this->Server->get('username'));
            $this->resetToken();
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Finally, store the user and open up the administration.
        $this->Logger->notice('User "' . $user->getUsername() . '" (#' . $user->getUserID() . ') signed in.');
        $login_audit->storeAttempt($this->Server->get('username'), null, true);
        $this->Session->set('User', $user);
        $response->redirect('/admin/', 303);
        exit;
    }

    /**
     * Retrieve the form token.
     *
     * @param void
     *
     * @return string
     *   Returns the active form token as a string.
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
        $view = new View();
        $view->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'SignIn.phtml');
        $view->setValues(array('token' => $this->getToken()));
        $view = $view->render();

        $document = new Document();
        $document->addSection($view);
        $document->setTitle(\StoreCore\I18N\COMMAND_SIGN_IN);

        /*
         * After 1 minute (60000 milliseconds) the current window times out,
         * JavaScript then redirects the client to the lock screen.
         */
        $document->addScript("window.setTimeout(function() { top.location.href = '/admin/lock/'; }, 60000);");

        $document = Minifier::minify($document);

        $factory = new ResponseFactory();
        $response = $factory->createResponse();
        $response->addHeader('Allow: GET, POST');
        $response->addHeader('X-Robots-Tag: noindex');
        $response->setResponseBody($document);
        $response->output();
    }

    /**
     * Reset the form token.
     *
     * @param void
     * @return void
     * @uses \StoreCore\Types\FormToken::getInstance()
     */
    private function resetToken()
    {
        $this->Token = FormToken::getInstance();
        $this->Session->set('Token', $this->Token);
    }
}
