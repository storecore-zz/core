<?php
namespace StoreCore;

use \Psr\Http\Message\MessageInterface;
use \Psr\Http\Message\StreamInterface;
use \StoreCore\TemporaryStream;

/**
 * HTTP Message
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-7-http-message.md
 * @version   0.1.0
 */
class Message implements MessageInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var StreamInterface $Body
     *   Body of the message as a stream.
     */
    protected $Body;

    /**
     * @var array $Headers
     *   HTTP message headers.
     */
    protected $Headers = array();

    /**
     * @var string $ProtocolVersion
     *   HTTP version number (e.g., “1.1”, “1.0”).
     */
    private $ProtocolVersion;

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        if ($this->Body === null) {
            $this->setBody(new TemporaryStream(''));
        }
        return $this->Body;
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        $header = array();
        $name = strtoupper($name);
        foreach ($this->Headers as $key => $values) {
            if (strtoupper($key) === $name) {
                $header = array_merge($header, $values);
            }
        }
        return $header;
    }

    /**
     * {@inheritDoc}
     *
     * @uses \StoreCore\Message::hasHeader()
     *   Uses the `hasHeader()` method to determine of the `$name` header exists.
     *
     * @uses \StoreCore\Message::getHeader()
     *   Returns the `getHeader()` result as a string with comma-separated values.
     */
    public function getHeaderLine($name)
    {
        if ($this->hasHeader($name)) {
            return implode(', ', $this->getHeader($name));
        } else {
            return (string)null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->Headers;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        if ($this->ProtocolVersion === null) {
            $protocol_version = explode('/', $_SERVER['SERVER_PROTOCOL'], 2);
            $this->ProtocolVersion = $protocol_version[1];
        }

        return $this->ProtocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        if (array_key_exists($name, $this->Headers)) {
            return true;
        } else {
            $name = strtolower($name);
            $headers = array_change_key_case($this->Headers, CASE_LOWER);
            return array_key_exists($name, $headers);
        }
    }

    /**
     * Set the message body.
     *
     * @param StreamInterface $body
     *   Body of the message as a stream.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception when the body is not valid.
     */
    public function setBody(StreamInterface $body)
    {
        if (!($body instanceof StreamInterface)) {
            throw new \InvalidArgumentException;
        }
        $this->Body = $body;
    }

    /**
     * Add an HTTP header to the message.
     *
     * @param string $name
     *   Case-insensitive name of the HTTP-header.
     *
     * @param string|string[] $value
     *   Header value(s) as a string or an array consisting of strings.
     *
     * @return void
     */
    public function setHeader($name, $value)
    {
        if ($name === 'User-Agent') {
            $this->Headers[$name] = array($value);
        } else {
            if (is_string($value)) {
                $value = str_replace(', ', ',', $value);
                $value = explode(',', $value);
            }
            if (is_array($value)) {
                $this->Headers[$name] = $value;
            } else {
                throw new \InvalidArgumentException();
            }
        }
    }

    /**
     * Remove a HTTP message header.
     *
     * @param string $name
     *   Case-insensitive name of the header to remove.
     *
     * @return void
     */
    private function unsetHeader($name)
    {
        unset($this->Headers[$name]);

        $name = strtolower($name);
        foreach ($this->Headers as $key => $value) {
            if (strtolower($key) === $name) {
                unset($this->Headers[$key]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        $message = clone $this;

        if ($message->hasHeader($name)) {
            $existing_value = $message->getHeader($name);
            if (is_string($value)) {
                $value = explode(',', $value);
            }
            $value = array_merge($existing_value, $value);
            $message->unsetHeader($name);
        }

        $message->setHeader($name, $value);
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $message = clone $this;
        $message->setBody($body);
        return $message;
    }

    /**
     * {@inheritDoc}
     *
     * @uses \StoreCore\Message::unsetHeader()
     *   This method first uses `unsetHeader()` to first remove any existing headers.
     *
     * @uses \StoreCore\Message::setHeader()
     *   The method next executes `setHeader()` to add a new header.
     */
    public function withHeader($name, $value)
    {
        $message = clone $this;
        $message->unsetHeader($name);
        $message->setHeader($name, $value);
        return $message;
    }

    /**
     * {@inheritDoc}
     *
     * @uses \StoreCore\Message::unsetHeader()
     *   Uses the private method `unsetHeader()` to remove an existing header
     *   from an instance of the message.
     */
    public function withoutHeader($name)
    {
        $message = clone $this;
        $message->unsetHeader($name);
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($protocol_version)
    {
        $message = clone $this;
        $message->ProtocolVersion = $protocol_version;
        return $message;
    }
}
