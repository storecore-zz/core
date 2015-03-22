<?php
namespace StoreCore;

/**
 * Client Request
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore
 * @version   0.0.1
 */
class Request
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /** @type string|null $RequestMethod */
    private $RequestMethod;

    /**
     * @type array|null $Cookies
     * @type array      $Server
     */
    private $Cookies;
    private $Server;

    public function __construct()
    {
        $magic_quotes_gpc = get_magic_quotes_gpc();

        // Server variables
        $data = array();
        foreach ($_SERVER as $key => $value) {
            if (!empty($value)) {
                if ($magic_quotes_gpc !== false) {
                    $value = stripslashes($value);
                }
                $data[$key] = $value;
            }
        }
        $this->Server = $data;

        // Request method (GET, POST, HEAD, etc.)
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if ($magic_quotes_gpc !== false) {
                $_SERVER['REQUEST_METHOD'] = stripslashes($_SERVER['REQUEST_METHOD']);
            }
            $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
            unset($this->Server['REQUEST_METHOD']);
        }

        // Add cookie data
        if (isset($_COOKIE) && !empty($_COOKIE)) {
            $data = array();
            foreach ($_COOKIE as $name => $value) {
                if (is_string($name) && !empty($value)) {
                    if ($magic_quotes_gpc !== false) {
                        $name = stripslashes($name);
                        $value = stripslashes($value);
                    }
                    $name = strtolower($name);
                    $data[$name] = $value;
                }
            }
            if (count($data) > 1) {
                $this->Cookies = $data;
            }
        }
    }

    /**
     * Set the request method.
     *
     * The HTTP request method in the superglobal PHP variable 
     * $_SERVER['REQUEST_METHOD'] is controlled by the client.  It MAY be
     * considered reliable as long as the web server allows only certain
     * request methods.
     *
     * @param string $method
     * @param return void
     */
    private function setRequestMethod($method)
    {
        if (!is_string($method)) {
            return;
        }

        $method = strip_tags($method);
        $method = trim($method);
        $method = strtoupper($method);

        if (!empty($method)) {
            $this->RequestMethod = $method;
        }
    }

    /**
     * Get the current request method.
     *
     * @param void
     * @return string|null
     */
    public function getRequestMethod()
    {
        return $this->RequestMethod;
    }


    /**
     * Get a cookie by name.
     *
     * @param string $cookie_name
     * @return mixed|null
     */
    public function getCookie($cookie_name)
    {
        if ($this->hasCookie[$cookie_name]) {
            return $this->Cookies[$cookie_name];
        } else {
            return null;
        }
    }

    /**
     * Check if a cookie exists
     *
     * @param string $cookie_name
     * @return bool
     */
    public function hasCookie($cookie_name)
    {
        if (!is_array($this->Cookies)) {
            return false;
        }
        return array_key_exists($cookie_name, $this->Cookies);
    }
}
