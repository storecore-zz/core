<?php
namespace StoreCore\StoreFront;

/**
 * Uniform Resource Identifier (URI)
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Location extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

    /** @var string $Location */
    private $Location;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);

        $this->set($this->Request->getHostName() . $this->Request->getRequestPath());
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * @param void
     * @return string
     */
    public function get()
    {
        return $this->Location;
    }

    /**
     * Set the location by a URI or URL.
     *
     * @param string $uri
     *
     * @return void
     *
     * @todo This method strips index file names like "index.php" from URLs, so
     *   these currently are simply ignored.  Another, more strict approach
     *   would be to disallow directory listings with a "Directory listing
     *   denied" HTTP response or a redirect.
     */
    public function set($uri)
    {
        // Remove query string parameters
        $uri = explode('?', $uri)[0];

        // Enforce lowercase URLs
        $uri = mb_strtolower($uri, 'UTF-8');

        // Drop common webserver directory indexes
        $uri = str_replace(array('default.aspx', 'default.asp', 'index.html', 'index.htm', 'index.shtml', 'index.php'), null, $uri);
        // Strip common extensions
        $uri = str_replace(array('.aspx', '.asp', '.html', '.htm', '.jsp', '.php'), null, $uri);

        // Replace special characters
        $uri = preg_replace('~[^\\pL\d.]+~u', '-', $uri);
        $uri = trim($uri, '-');
        $uri = iconv('UTF-8', 'US-ASCII//TRANSLIT//IGNORE', $uri);
        $uri = str_ireplace(array('"', '`', '^', '~'), null, $uri);
        $uri = urlencode($uri);

        $this->Location = $uri;
    }
}
