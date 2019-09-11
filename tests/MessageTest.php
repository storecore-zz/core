<?php
/**
 * @group hmvc
 */
class MessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Message class file exists
     */
    public function testMessageClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Message.php');
    }

    /**
     * @group hmvc
     * @testdox Message class is not abstract
     */
    public function testMessageClassIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertFalse($class->isAbstract());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Message::VERSION);
        $this->assertInternalType('string', \StoreCore\Message::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Message::VERSION);
    }


    /**
     * @testdox Message::getHeader() exists
     */
    public function testMessageGetHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('getHeader'));
    }

    /**
     * @depends testMessageGetHeaderExists
     * @testdox Message::getHeader() is public
     */
    public function testMessageGetHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageGetHeaderExists
     * @testdox Message::getHeader() has one required parameter
     */
    public function testMessageGetHeaderHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeader');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testMessageGetHeaderHasOneRequiredParameter
     * @testdox Message::getHeader() returns array
     */
    public function testMessageGetHeaderReturnsArray()
    {
        $message = new \StoreCore\Message();
        $this->assertInternalType('array', $message->getHeader('Accept-Language'));
    }


    /**
     * @testdox Message::getHeaderLine() exists
     */
    public function testMessageGetHeaderLineExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('getHeaderLine'));
    }

    /**
     * @depends testMessageGetHeaderLineExists
     * @testdox Message::getHeaderLine() is public
     */
    public function testMessageGetHeaderLineIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeaderLine');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageGetHeaderLineExists
     * @testdox Message::getHeaderLine() has one required parameter
     */
    public function testMessageGetHeaderLineHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeaderLine');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testMessageGetHeaderLineHasOneRequiredParameter
     * @testdox Message::getHeaderLine() returns string
     */
    public function testMessageGetHeaderLineReturnsString()
    {
        $message = new \StoreCore\Message();
        $this->assertInternalType('string', $message->getHeaderLine('Accept-Language'));
    }


    /**
     * @testdox Message::getHeaders() exists
     */
    public function testMessageGetHeadersExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('getHeaders'));
    }

    /**
     * @depends testMessageGetHeadersExists
     * @testdox Message::getHeaders() is public
     */
    public function testMessageGetHeadersIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeaders');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageGetHeadersExists
     * @testdox Message::getHeaders() has no parameters
     */
    public function testMessageGetHeadersHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getHeaders');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testMessageGetHeadersExists
     * @testdox Message::getHeaders() returns array
     */
    public function testMessageGetHeadersReturnsArray()
    {
        $message = new \StoreCore\Message();
        $this->assertInternalType('array', $message->getHeaders());
    }


    /**
     * @testdox Message::getProtocolVersion() exists
     */
    public function testMessageGetProtocolVersionExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('getProtocolVersion'));
    }

    /**
     * @depends testMessageGetProtocolVersionExists
     * @testdox Message::getProtocolVersion() is public
     */
    public function testMessageGetProtocolVersionIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getProtocolVersion');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageGetProtocolVersionExists
     * @testdox Message::getProtocolVersion() has no parameters
     */
    public function testMessageGetProtocolVersionHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'getProtocolVersion');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Message::getProtocolVersion() returns non-empty string
     */
    public function testMessageGetProtocolVersionReturnsNonEmptyString()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $message = new \StoreCore\Message();
        $this->assertNotEmpty($message->getProtocolVersion());
        $this->assertInternalType('string', $message->getProtocolVersion());
    }

    /**
     * @testdox Message::getProtocolVersion() returns protocol version only
     */
    public function testMessageGetProtocolVersionReturnsProtocolVersionOnly()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $message = new \StoreCore\Message();
        $this->assertSame('1.1', $message->getProtocolVersion());
    }


    /**
     * @testdox Message::hasHeader() exists
     */
    public function testMessageHasHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('hasHeader'));
    }

    /**
     * @depends testMessageHasHeaderExists
     * @testdox Message::hasHeader() is public
     */
    public function testMessageHasHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'hasHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageHasHeaderExists
     * @testdox Message::hasHeader() has one required parameter
     */
    public function testMessageHasHeaderHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'hasHeader');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testMessageHasHeaderHasOneRequiredParameter
     * @testdox Message::hasHeader() returns boolean
     */
    public function testMessageHasHeaderReturnsBoolean()
    {
        $message = new \StoreCore\Message();
        $this->assertInternalType('bool', $message->hasHeader('Accept-Language'));
    }


    /**
     * @testdox Message::setHeader() exists
     */
    public function testMessageSetHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('setHeader'));
    }

    /**
     * @depends testMessageSetHeaderExists
     * @testdox Message::setHeader() is public
     */
    public function testMessageSetHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'setHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageSetHeaderExists
     * @testdox Message::setHeader() has two required parameters
     */
    public function testMessageSetHeaderHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'setHeader');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }


    /**
     * @testdox Message::withAddedHeader() exists
     */
    public function testMessageWithAddedHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('withAddedHeader'));
    }

    /**
     * @depends testMessageWithAddedHeaderExists
     * @testdox Message::withAddedHeader() is public
     */
    public function testMessageWithAddedHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withAddedHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageWithAddedHeaderExists
     * @testdox Message::withAddedHeader() has two required parameters
     */
    public function testMessageWithAddedHeaderHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withAddedHeader');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }

    /**
     * @depends testMessageWithAddedHeaderHasTwoRequiredParameters
     * @testdox Message::withAddedHeader() returns instance of Message
     */
    public function testMessageWithAddedHeaderReturnsInstanceOfMessage()
    {
        $message = new \StoreCore\Message();
        $this->assertInstanceOf(\StoreCore\Message::class, $message->withAddedHeader('Accept-Encoding', 'gzip, deflate'));
    }

    /**
     * @depends testMessageWithAddedHeaderReturnsInstanceOfMessage
     * @testdox Message::withAddedHeader() adds header values
     */
    public function testMessageWithAddedHeaderAddsHeaderValues()
    {
        $first_message = new \StoreCore\Message();
        $first_message->setHeader('Accept-Encoding', 'deflate');
        $second_message = $first_message->withAddedHeader('Accept-Encoding', 'gzip');

        $this->assertTrue(count($first_message->getHeader('Accept-Encoding')) === 1);
        $this->assertTrue(count($second_message->getHeader('Accept-Encoding')) === 2);

        $this->assertSame('deflate', $first_message->getHeaderLine('Accept-Encoding'));
        $this->assertSame('deflate, gzip', $second_message->getHeaderLine('Accept-Encoding'));
    }


    /**
     * @testdox Message::withHeader() exists
     */
    public function testMessageWithHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('withHeader'));
    }

    /**
     * @depends testMessageWithHeaderExists
     * @testdox Message::withHeader() is public
     */
    public function testMessageWithHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageWithHeaderExists
     * @testdox Message::withHeader() has two required parameters
     */
    public function testMessageWithHeaderHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withHeader');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }

    /**
     * @depends testMessageWithHeaderHasTwoRequiredParameters
     * @testdox Message::withHeader() returns instance of Message
     */
    public function testMessageWithHeaderReturnsInstanceOfMessage()
    {
        $message = new \StoreCore\Message();
        $this->assertInstanceOf(\StoreCore\Message::class, $message->withHeader('Accept-Encoding', 'gzip, deflate'));
    }

    /**
     * @depends testMessageWithHeaderReturnsInstanceOfMessage
     * @testdox Message::withHeader() adds header
     */
    public function testMessageWithHeaderAddsHeader()
    {
        $first_message = new \StoreCore\Message();
        $second_message = $first_message->withHeader('Accept-Encoding', 'gzip, deflate');

        $this->assertEmpty($first_message->getHeader('Accept-Encoding'));
        $this->assertNotEmpty($second_message->getHeader('Accept-Encoding'));

        $this->assertEquals('', $first_message->getHeaderLine('Accept-Encoding'));
        $this->assertEquals('gzip, deflate', $second_message->getHeaderLine('Accept-Encoding'));
    }


    /**
     * @testdox Message::withoutHeader() exists
     */
    public function testMessageWithoutHeaderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('withoutHeader'));
    }

    /**
     * @depends testMessageWithoutHeaderExists
     * @testdox Message::withoutHeader() is public
     */
    public function testMessageWithoutHeaderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withoutHeader');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageWithoutHeaderExists
     * @testdox Message::withoutHeader() has one required parameter
     */
    public function testMessageWithoutHeaderHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withoutHeader');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testMessageWithoutHeaderHasOneRequiredParameter
     * @testdox Message::withoutHeader() returns instance of Message
     */
    public function testMessageWithoutHeaderReturnsInstanceOfMessage()
    {
        $message = new \StoreCore\Message();
        $this->assertInstanceOf(\StoreCore\Message::class, $message->withoutHeader('User-Agent'));
    }


    /**
     * @testdox Message::withProtocolVersion() exists
     */
    public function testMessageWithProtocolVersionExists()
    {
        $class = new \ReflectionClass('\StoreCore\Message');
        $this->assertTrue($class->hasMethod('withProtocolVersion'));
    }

    /**
     * @depends testMessageWithProtocolVersionExists
     * @testdox Message::withProtocolVersion() is public
     */
    public function testMessageWithProtocolVersionIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withProtocolVersion');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testMessageWithProtocolVersionExists
     * @testdox Message::withProtocolVersion() has one required parameter
     */
    public function testMessageWithProtocolVersionHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Message', 'withProtocolVersion');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testMessageWithProtocolVersionHasOneRequiredParameter
     * @testdox Message::withProtocolVersion() returns instance of Message
     */
    public function testMessageWithProtocolVersionReturnsInstanceOfMessage()
    {
        $message = new \StoreCore\Message();
        $this->assertInstanceOf(\StoreCore\Message::class, $message->withProtocolVersion('1.0'));
    }
}
