<?php
namespace StoreCore;

use \Psr\Http\Message\ServerRequestInterface;
use \StoreCore\Request;

/**
 * PSR-7 compliant server-side HTTP request.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-7-http-message.md#321-psrhttpmessageserverrequestinterface
 * @version   0.1.0
 */
class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $Attributes
     *   Generic data injection container for parameters that may be derived
     *   from the request.
     */
    private $Attributes = array();

    /**
     * @var array $CookieParams
     *   Cookies sent by the client to the server.  The data MUST be compatible
     *   with the structure of the PHP `$_COOKIE` superglobal.
     */
    private $CookieParams = array();

    /**
     * @var array $ParsedBody
     *   Deserialized body data.  This will typically be in an array or object.
     */
    private $ParsedBody;

    /**
     * @var array $QueryParams
     *   Deserialized query string arguments, if any.
     */
    private $QueryParams = array();

    /**
     * @var array $UploadedFiles
     *   Array tree of PSR-7 UploadedFileInterface instances.  This array MUST
     *   be empty if no data is present.
     */
    private $UploadedFiles = array();

    /**
     * @var array $ServerParams
     *   Server parameters including, but not limited to, the PHP superglobal
     *   array `$_SERVER`.  Defaults to a `HTTP GET` request.
     */
    private $ServerParams = array(
        'REQUEST_METHOD' => 'GET',
        'REQUEST_SCHEME' => 'http',
    );

    /**
     * @inheritdoc
     */
    public function getAttribute($name, $default = null)
    {
        if (array_key_exists($name, $this->Attributes)) {
            return $this->Attributes[$name];
        } else {
            return $default;
        }
    }

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return $this->Attributes;
    }

    /**
     * @inheritDoc
     */
    public function getCookieParams()
    {
        return $this->CookieParams;
    }

    /**
     * @inheritDoc
     */
    public function getParsedBody()
    {
        return $this->ParsedBody;
    }

    /**
     * @inheritDoc
     */
    public function getQueryParams()
    {
        return $this->QueryParams;
    }

    /**
     * @inheritDoc
     */
    public function getServerParams()
    {
        return $this->ServerParams;
    }

    /**
     * @inheritdoc
     */
    public function getUploadedFiles()
    {
        return $this->UploadedFiles;
    }

    /**
     * Add an attribute.
     *
     * @param string $name
     *   Name of the attribute to add.
     * 
     * @param mixed $value
     *   Value of the attribute.
     *
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->Attributes[$name] = $value;
    }

    /**
     * Set cookies.
     *
     * @param array $cookie_parameters
     *   Array of key/value pairs representing cookies.
     *
     * @return void
     */
    public function setCookieParams(array $cookie_parameters)
    {
        if (!is_array($cookie_parameters)) {
            throw new \InvalidArgumentException();
        }
        $this->CookieParams = array_merge($this->CookieParams, $cookie_parameters);
    }

    /**
     * Set the request body.
     * 
     * @param null|array|object $data
     *   Deserialized body data.
     *
     * @return void
     */
    public function setParsedBody($data)
    {
        $this->ParsedBody = $data;
    }

    /**
     * Set query string parameters.
     *
     * @param array $query
     *   Query string arguments as deserialized key/value pairs.
     *
     * @return void
     */
    public function setQueryParams(array $query)
    {
        $this->QueryParams = array_merge($this->QueryParams, $query);
    }

    /**
     * Set server parameters.
     *
     * @param array $server_parameters
     *   Array of Server API (SAPI) parameters for the server request instance.
     *
     * @return void
     */
    public function setServerParams(array $server_parameters)
    {
        $this->ServerParams = array_merge($this->ServerParams, $server_parameters);
    }

    /**
     * Add uploaded files.
     *
     * @param array $uploaded_files
     *   An array tree of PSR-7 UploadedFileInterface instances.
     *
     * @return void
     */
    public function setUploadedFiles($uploaded_files)
    {
        $this->UploadedFiles = array_merge($this->UploadedFiles, $uploaded_files);
    }

    /**
     * Remove an attribute from the request.
     *
     * @param string $name
     *   Name of the attribute to remove.
     *
     * @return bool
     *   Returns true on success or false if the attribute does not exist.
     */
    public function unsetAttribute($name)
    {
        if (array_key_exists($name, $this->Attributes)) {
            unset($this->Attributes[$name]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function withAttribute($name, $value)
    {
        $request = clone $this;
        $request->setAttribute($name, $value);
        return $request;
    }

    /**
     * {@inheritDoc}
     *
     * @uses unsetAttribute()
     *   Uses \StoreCore\ServerRequest::unsetAttribute() to remove the
     *   attribute from the new request.
     */
    public function withoutAttribute($name)
    {
        $request = clone $this;
        $request->unsetAttribute($name);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withCookieParams(array $cookies)
    {
        $request = clone $this;
        $request->setCookieParams($cookies);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withParsedBody($data)
    {
        $request = clone $this;
        $request->setParsedBody($data);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withQueryParams(array $query)
    {
        $request = clone $this;
        $request->setQueryParams($query);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withServerParams(array $server_parameters)
    {
        $request = clone $this;
        $request->setServerParams($server_parameters);
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withUploadedFiles(array $uploaded_files)
    {
        $request = clone $this;
        $request->setUploadedFiles($uploaded_files);
        return $request;
    }
}
