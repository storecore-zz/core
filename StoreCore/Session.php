<?php
namespace StoreCore;

/**
 * Session
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Session extends AbstractSubject implements SubjectInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var int $IdleTimeout
     *   Time-out of an inactive session in minutes.
     */
    private $IdleTimeout = 15;

    /**
     * @param int $idle_timeout
     *   Optional idle timeout in minutes.  Defaults to 15 minutes.  Common
     *   idle timeouts are 2 to 5 minutes for high-value applications and
     *   15 to 30 minutes for low risk applications.  The default maximum
     *   is 30 minutes.
     *
     * @return self
     */
    public function __construct($idle_timeout = 15)
    {
        if (!session_id()) {
            ini_set('session.use_only_cookies', '1');
            ini_set('session.use_trans_sid', '0');
            ini_set('session.cookie_httponly', '1');

            if ($idle_timeout > 30) {
                $idle_timeout = 30;
            }
            $this->IdleTimeout = (int)$idle_timeout;
            session_cache_expire($this->IdleTimeout);
            ini_set('session.gc_maxlifetime', $this->IdleTimeout * 60);

            // Use SHA-1 (1) instead of MD5 (PHP default 0)
            ini_set('session.hash_function', '1');

            // Attempt to use SHA-2 instead of SHA-1
            $hash_algos = hash_algos();
            if (in_array('sha512', $hash_algos)) {
                ini_set('session.hash_function', 'sha512');
            } elseif (in_array('sha384', $hash_algos)) {
                ini_set('session.hash_function', 'sha384');
            } elseif (in_array('sha256', $hash_algos)) {
                ini_set('session.hash_function', 'sha256');
            } elseif (in_array('sha224' , $hash_algos)) {
                ini_set('session.hash_function', 'sha224');
            }

            session_set_cookie_params(0, '/');
            session_start();
        }

        // Regenerate the session ID when switching from HTTP to HTTP/S.
        if (isset($_SERVER['HTTPS'])) {
            if (!isset($_SESSION['HTTPS']) ) {
                $_SESSION['HTTPS'] = $_SERVER['HTTPS'];
            } elseif ($_SESSION['HTTPS'] !== $_SERVER['HTTPS']) {
                $this->regenerate();
            }
        }

        // Destroy the session if the browser "fingerprint" has changed.
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            if (!isset($_SESSION['HTTP_USER_AGENT'])) {
                $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
            } elseif ($_SESSION['HTTP_USER_AGENT'] !== $_SERVER['HTTP_USER_AGENT']) {
                $this->destroy();
                $this->regenerate();
            }
        }

        // Create an object pool
        if (!array_key_exists('SESSION_OBJECT_POOL', $_SESSION)) {
            $_SESSION['SESSION_OBJECT_POOL'] = array();
        }
    }

    /**
     * Destroy the session.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function destroy()
    {
        $_SESSION = array();
        if (!headers_sent() && ini_get('session.use_cookies')) {
            $cookie_params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $cookie_params['path'], $cookie_params['domain'],
                $cookie_params['secure'], $cookie_params['httponly']
            );
        }
        $session_destroyed = session_destroy();
        $this->notify();
        return $session_destroyed;
    }

    /**
     * Get the value of a session variable.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (isset($_SESSION['SESSION_OBJECT_POOL'][$key])) {
            return unserialize($_SESSION['SESSION_OBJECT_POOL'][$key]);
        } elseif (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * Get the current session ID.
     *
     * @param void
     * @return string
     */
    public function getSessionID()
    {
        return session_id();
    }

    /**
     * Check if a session variable exists.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        if (isset($_SESSION['SESSION_OBJECT_POOL'][$key])) {
            return true;
        } else {
            return isset($_SESSION[$key]);
        }
    }

    /**
     * Generate a new session ID.
     *
     * @param void
     * @return bool
     */
    public function regenerate()
    {
        $return = session_regenerate_id(true);
        $this->notify();
        return $return;
    }

    /**
     * Set a session value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws \InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (
            !is_string($key)
            || $key == 'HTTP_USER_AGENT'
            || $key == 'HTTPS'
            || $key == 'SESSION_OBJECT_POOL'
        ) {
            throw new \InvalidArgumentException();
        }

        if (is_object($value)) {
            $_SESSION['SESSION_OBJECT_POOL'][$key] = serialize($value);
        } else {
            $_SESSION[$key] = $value;
        }

        $this->notify();
    }
}
