<?php
namespace StoreCore\Admin;

use \StoreCore\Response as Response;

class SignIn extends \StoreCore\AbstractController
{
    /**
     * @var string $Token
     */
    private $Token;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $logger = new \StoreCore\FileSystem\Logger();

        if ($this->Request->getRequestMethod() == 'GET') {
            $this->resetToken();
            $this->render();
            exit;
        } elseif ($this->Request->getRequestMethod() != 'POST') {
            // Only allow GET or POST requests
            $this->resetToken();
            header('Allow: GET, POST');
            header('HTTP/1.1 405 Method Not Allowed', true, 405);
            $logger->warning('HTTP/1.1 405 Method Not Allowed');
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
        $login_audit = new \StoreCore\Database\LoginAudit();

        // Token handshake
        if ($this->Request->get('token') != $this->Session->get('Token')) {
            $logger->notice('Token mismatch in admin sign-in.');
            $this->resetToken();
            $response = new Response($this->Registry);
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Check recent failed attempts
        $minutes = 15;
        $failed_attempts = $login_audit->countLastFailedAttempts($minutes);
        if ($failed_attempts > 10) {
            $logger->warning('There were over 10 failed admin sign-in attempts in the last ' . $minutes . ' minutes.');
        }

        // Connection throttling: pause for 2 ^ n seconds.
        // Maximum execution is set to the PHP default minus 2 seconds.
        $seconds = pow(2, (int)($failed_attempts / 10));
        $max_execution_time = (int)ini_get('max_execution_time') - 2;
        if ($seconds > $max_execution_time) {
            $seconds = $max_execution_time;
        }
        sleep($seconds);

        // Try to fetch the user.
        $user_mapper = new \StoreCore\Database\UserMapper();
        $user = $user_mapper->getUserByUsername($this->Request->get('username'));
        if ($user === null) {
            $logger->warning('Unknown user "' . $this->Request->get('username') . '" attempted to sign in.');
            $login_audit->storeAttempt($this->Request->get('username'));
            $this->resetToken();
            $response = new Response($this->Registry);
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Check the user password.
        if ($user->authenticate($this->Request->get('password')) == false) {
            $logger->warning('Known user "' . $this->Request->get('username') . '" attempted to sign in with an illegal password.');
            $login_audit->storeAttempt($this->Request->get('username'));
            $this->resetToken();
            $response = new Response($this->Registry);
            $response->redirect('/admin/sign-in/', 303);
            exit;
        }

        // Finally, store the user and open up the administration.
        $logger->notice('User "' . $this->Request->get('username') . '" signed in.');
        $login_audit->storeAttempt($this->Request->get('username'), null, true);
        $this->Session->set('User', $user);
        $response = new Response($this->Registry);
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
        $document->setTitle(STORECORE_I18N_COMMAND_SIGN_IN);
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
        $token = (string)null;
        for ($i = 1; $i <= 512; $i++) {
            switch (mt_rand(0, 2)) {
                case 0:
                    $ascii = mt_rand(48, 57);
                    break;
                case 1:
                    $ascii = mt_rand(65, 90);
                    break;
                default:
                    $ascii = mt_rand(97, 122);

            }
            $token .= chr($ascii);
        }
        $this->Token = $token;
        $this->Session->set('Token', $token);
    }
}
