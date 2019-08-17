<?php
namespace StoreCore;

use StoreCore\Types\StringableInterface;

/**
 * Uniform Resource Identifier (URI).
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.2.0
 */
class Location extends \StoreCore\AbstractModel implements StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.2.0';

    /**
     * @var string $Location
     *   Location of a web page, asset, or some other resource.
     */
    private $Location;

    /**
     * Create a location data object.
     *
     * @param \StoreCore\Registry $registry
     *   Global service locator.
     *
     * @return self
     *
     * @uses \StoreCore\Request::getHostName()
     *
     * @uses \StoreCore\Request::getRequestPath()
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);
        $this->set($this->Request->getHostName() . $this->Request->getRequestPath());
    }

    /**
     * Convert the location to a URL string.
     *
     * @param void
     *
     * @return string
     *   Returns the current location as a string.
     *
     * @uses \StoreCore\Location::get()
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Get the current location.
     *
     * @param void
     *
     * @return string
     *   Returns the current location as a string.
     */
    public function get()
    {
        return $this->Location;
    }

    /**
     * Set the location by a URI or URL.
     *
     * @param string $uri
     *   Uniform resource identifier (URI) or uniform resource locator (URL)
     *   for the current location.
     *
     * @return void
     *
     * @todo This method strips index file names like “index.php” from URLs, so
     *   these currently are simply ignored.  Another, more strict approach
     *   would be to disallow directory listings with a “Directory listing
     *   denied” HTTP response or a redirect.
     */
    public function set($uri)
    {
        // Remove query string parameters
        $uri = explode('?', $uri)[0];

        // Enforce lowercase URLs
        $uri = mb_strtolower($uri, 'UTF-8');

        // Protocol prefixes
        $uri = str_ireplace(array('http://', 'https://'), '//', $uri);

        // Drop common webserver directory indexes
        $uri = str_replace(array('default.aspx', 'default.asp', 'default.html', 'default.htm'), null, $uri);
        $uri = str_replace(array('home.html', 'home.htm'), null, $uri);
        $uri = str_replace(array('index.cgi', 'index.dhtml', 'index.html', 'index.htm', 'index.shtml', 'index.php', 'index.pl'), null, $uri);

        // Strip common extensions
        $uri = str_replace(array('.aspx', '.asp', '.dhtml', '.html', '.htm', '.jsp', '.php', '.pl', '.shtml'), null, $uri);

        // Replace special characters
        $uri = str_ireplace(array(' \\ ', '\\ ', ' \\', '\\', ' > ', '> ', ' >', '>', ' » ', '» ', ' »', '»', ' | ', '| ', ' |', '|', ' / ', '/ ', ' /'), '/', $uri);
        $uri = str_ireplace(array('(', ')'), null, $uri);
        $uri = iconv('UTF-8', 'ASCII//TRANSLIT', $uri);
        $uri = str_ireplace(array('"', '\'', '`', '^', '~', '(', ')'), null, $uri);
        $uri = str_ireplace(' ', '-', $uri);
        $uri = rawurlencode($uri);

        // Slashes
        $uri = str_replace('%2F', '/', $uri);
        $uri = preg_replace('~/+~', '/', $uri);
        $uri = '//' . ltrim($uri, '/');

        $this->Location = $uri;
    }
}
