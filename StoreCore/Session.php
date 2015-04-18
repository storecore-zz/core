<?php
namespace StoreCore;

/**
 * Session
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore
 * @version   0.0.2
 */
class Session
{
    /** @var string VERSION */
    const VERSION = '0.0.2';

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
     */
    public function __construct($idle_timeout = 15)
    {
        if (!session_id()) {
            ini_set('session.use_only_cookies', '1');
            ini_set('session.use_trans_sid', '0');
            ini_set('session.cookie_httponly', '1');

            if ($idle_timeout != null) {
                if ($idle_timeout > 30) {
                    $idle_timeout = 30;
                }
                $this->IdleTimeout = (int)$idle_timeout;
            }
            session_cache_expire($this->IdleTimeout);
            ini_set('session.gc_maxlifetime', $this->IdleTimeout * 60);

            ini_set('session.hash_function', '1');
            $hash_algos = hash_algos();
            if (in_array('sha512', $hash_algos)) {
                ini_set('session.hash_function', 'sha512');
            } elseif (in_array('sha384', $aHashAlgos)) {
                ini_set('session.hash_function', 'sha384');
            } elseif (in_array('sha256', $aHashAlgos)) {
                ini_set('session.hash_function', 'sha256');
            } elseif (in_array('sha224' , $aHashAlgos)) {
                ini_set('session.hash_function', 'sha224');
            }

            session_set_cookie_params(0, '/');
            session_start();
        }
    }

    /**
     * @param string $name
     * @return void
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }


    /**
     * Destroy the session.
     *
     * @param void
     * @return bool
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
        return session_destroy();
    }

    /**
     * Get the value of a session variable.
     *
     * @param string $name
     * @return mixed|null
     */
    public function get($name)
    {
        if (array_key_exists($name, $_SESSION)) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * Check if a session variable exists.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $_SESSION);
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
     * Set a session value.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set($name, $value)
    {
        $_SESSION[(string)$name] = $value;
    }
}
