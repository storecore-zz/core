<?php
namespace StoreCore;

use \Psr\Http\Message\StreamFactoryInterface;
use \Psr\Http\Message\StreamInterface;
use \StoreCore\TemporaryStream;
use \StoreCore\FileSystem\FileStream;
use \StoreCore\Types\StringableInterface;

/**
 * PSR-17 HTTP stream factory.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-17-http-factory.md#24-streamfactoryinterface
 *      PSR-17 HTTP Factories StreamFactoryInterface
 *
 * @see https://www.php-fig.org/psr/psr-17/#24-streamfactoryinterface
 *      PSR-17 HTTP Factories StreamFactoryInterface
 */
class StreamFactory implements StreamFactoryInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function createStream($content = '')
    {
        return new TemporaryStream($content);
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromFile($filename, $mode = 'r')
    {
        if (!is_file($filename) || is_dir($filename)) {
            throw new \RuntimeException(__METHOD__ . ' expects parameter 1 to be the filename of an existing file');
        } 

        try {
            return new FileStream($filename, $mode);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @throws \RuntimeException
     *   According to the PSR-17 standard, the returned stream MUST be readable
     *   and MAY be writable.  This method therefore throws a runtime exception
     *   if the stream is not readable.
     */
    public function createStreamFromResource($resource)
    {
        if ($resource instanceof StreamInterface) {
            if (!$resource->isReadable()) {
                throw new \RuntimeException('Resource is not readable');
            }
            return $resource;
        }

        if (is_string($resource) && is_file($resource)) {
            try {
                $stream = $this->createStreamFromFile($resource);
            } catch (\Exception $e) {
                throw new \RuntimeException('Cannot create stream from resource', $e->getCode(), $e);
            }

            if (!$stream->isReadable()) {
                throw new \RuntimeException('Resource is not readable');
            }
            return $stream;
        }

        if ($resource instanceof StringableInterface || is_string($resource) ) {
            $resource = (string) $resource;
            return $this->createStream($resource);
        }
    }


    /**
     * @testdox StreamFactory::createStreamFromResource() exists
     */
    public function testStreamFactoryCreateStreamFromResourceExists()
    {
        $class = new \ReflectionClass('\StoreCore\StreamFactory');
        $this->assertTrue($class->hasMethod('createStreamFromResource'));
    }

    /**
     * @depends testStreamFactoryCreateStreamFromResourceExists
     * @testdox StreamFactory::createStreamFromResource() is public
     */
    public function testStreamFactoryCreateStreamFromResourceIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStreamFromResource');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testStreamFactoryCreateStreamFromResourceHasTwoParameters
     * @testdox StreamFactory::createStreamFromResource() has one required parameter
     */
    public function testStreamFactoryCreateStreamFromResourceHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStreamFromResource');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
