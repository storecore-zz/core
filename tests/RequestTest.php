<?php
class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Request class file exists
     */
    public function testRequestClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Request.php');
    }

    /**
     * @group hmvc
     * @testdox Request class is concrete
     */
    public function testRequestClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Extended Message class file exists
     */
    public function testExtendedMessageClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Message.php');
    }

    /**
     * @group hmvc
     * @testdox Request is a Message
     */
    public function testRequestIsAMessage()
    {
        $request = new \StoreCore\Request();
        $this->assertInstanceOf(\StoreCore\Message::class, $request);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Request::VERSION);
        $this->assertInternalType('string', \StoreCore\Request::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Request::VERSION);
    }


    /**
     * @testdox Request::getMethod() exists
     */
    public function testRequestGetMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('getMethod'));
    }

    /**
     * @depends testRequestGetMethodExists
     * @testdox Request::getMethod() is public
     */
    public function testRequestGetMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getMethod');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestGetMethodExists
     * @testdox Request::getMethod() has no parameters
     */
    public function testRequestGetMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getMethod');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox HTTP request method GET is supported
     */
    public function testHttpRequestMethodGetIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $request = new \StoreCore\Request();
        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @testdox HTTP request method HEAD is supported
     */
    public function testHttpRequestMethodHeadIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'head';
        $request = new \StoreCore\Request();
        $this->assertEquals('HEAD', $request->getMethod());
    }

    /**
     * @testdox HTTP request method POST is supported
     */
    public function testHttpRequestMethodPostIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'post';
        $request = new \StoreCore\Request();
        $this->assertEquals('POST', $request->getMethod());
    }

    /**
     * @testdox HTTP request method PUT is supported
     */
    public function testHttpRequestMethodPutIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'put';
        $request = new \StoreCore\Request();
        $this->assertEquals('PUT', $request->getMethod());
    }

    /**
     * @testdox HTTP request method PATCH is supported
     */
    public function testHttpRequestMethodPatchIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'patch';
        $request = new \StoreCore\Request();
        $this->assertEquals('PATCH', $request->getMethod());
    }

    /**
     * @testdox HTTP request method DELETE is supported
     */
    public function testHttpRequestMethodDeleteIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'delete';
        $request = new \StoreCore\Request();
        $this->assertEquals('DELETE', $request->getMethod());
    }


    public function testKnownUserAgentsMatch()
    {
        $user_agents = array(
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0',
            'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36',
        );

        foreach ($user_agents as $user_agent) {
            $_SERVER['HTTP_USER_AGENT'] = $user_agent;
            $request = new \StoreCore\Request();
            $this->assertEquals($user_agent, $request->getUserAgent());
            $request = null;
        }
    }

    public function testUnknownUserAgentIsNull()
    {
        $_SERVER['HTTP_USER_AGENT'] = '';
        $request = new \StoreCore\Request();
        $this->assertNull($request->getUserAgent());
    }


    /**
     * @testdox Request::getRequestTarget() exists
     */
    public function testRequestGetRequestTargetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('getRequestTarget'));
    }

    /**
     * @depends testRequestGetRequestTargetExists
     * @testdox Request::getRequestTarget() is public
     */
    public function testRequestGetRequestTargetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getRequestTarget');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestGetRequestTargetExists
     * @testdox Request::getRequestTarget() has no parameters
     */
    public function testRequestGetRequestTargetHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getRequestTarget');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testRequestGetRequestTargetExists
     * @depends testRequestGetRequestTargetIsPublic
     * @depends testRequestGetRequestTargetHasNoParameters
     * @testdox Request::getRequestTarget() returns string
     */
    public function testRequestGetRequestTargetReturnsString()
    {
        $request = new \StoreCore\Request();
        $this->assertInternalType('string', $request->getRequestTarget());
    }

    /**
     * @depends testRequestGetRequestTargetReturnsString
     * @testdox Request::getRequestTarget() return is not empty
     */
    public function testRequestGetRequestTargetReturnIsNotEmpty()
    {
        $request = new \StoreCore\Request();
        $this->assertNotEmpty($request->getRequestTarget());
    }

    /**
     * @depends testRequestGetRequestTargetReturnsString
     * @testdox Request::getRequestTarget() returns '/' by default
     */
    public function testRequestGetRequestTargetReturnSlashByDefault()
    {
        $request = new \StoreCore\Request();
        $this->assertSame('/', $request->getRequestTarget());
    }


    /**
     * @testdox Request::getUri() exists
     */
    public function testRequestGetUriExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('getUri'));
    }

    /**
     * @depends testRequestGetUriExists
     * @testdox Request::getUri() is public
     */
    public function testRequestGetUriIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getUri');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestGetUriExists
     * @testdox Request::getUri() has no parameters
     */
    public function testRequestGetUriHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'getUri');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testRequestGetUriExists
     * @depends testRequestGetUriIsPublic
     * @depends testRequestGetUriHasNoParameters
     * @testdox Request::getUri() returns PSR-7 UriInterface
     */
    public function testRequestGetUriReturnsPsr7UriInterface()
    {
        // URI in PHP equals two server variables:
        // $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
        $_SERVER['HTTP_HOST']   = 'www.example.com';
        $_SERVER['REQUEST_URI'] = '/foo-category/bar-product-name';
        $_SERVER['SERVER_PORT'] = '80';

        $request = new \StoreCore\Request();
        $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $request->getUri());
    }


    /**
     * @testdox Request::setMethod() exists
     */
    public function testRequestSetMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('setMethod'));
    }

    /**
     * @depends testRequestSetMethodExists
     * @testdox Request::setMethod() is public
     */
    public function testRequestSetMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setMethod');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestSetMethodExists
     * @testdox Request::setMethod() has one required parameter
     */
    public function testRequestSetMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setMethod');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox Request::setMethod() is case sensitive
     */
    public function testRequestSetMethodIsCaseSensitive()
    {
        $request = new \StoreCore\Request();

        $request->setMethod('get');
        $this->assertNotEquals('GET', $request->getMethod());

        $request->setMethod('Get');
        $this->assertNotEquals('GET', $request->getMethod());

        $request->setMethod('GET');
        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @testdox Request::setMethod() sets Request::getMethod() return
     */
    public function testRequestSetMethodSetsRequestGetMethodReturn()
    {
        $methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE');
        foreach ($methods as $method) {
            $request = new \StoreCore\Request();
            $request->setMethod($method);
            $this->assertSame($method, $request->getMethod());
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Request::setMethod() throws invalid argument exception if HTTP method does not exist
     */
    public function RequestSetMethodThrowsInvalidArgumentExceptionIfHttpMethodDoesNotExist()
    {
        $request = new \StoreCore\Request();
        $request->setMethod('FOO');
    }


    /**
     * @testdox Request::setRequestTarget() exists
     */
    public function testRequestSetRequestTargetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('setRequestTarget'));
    }

    /**
     * @depends testRequestSetRequestTargetExists
     * @testdox Request::setRequestTarget() is public
     */
    public function testRequestSetRequestTargetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setRequestTarget');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestSetRequestTargetExists
     * @testdox Request::setRequestTarget() has one required parameter
     */
    public function testRequestSetRequestTargetHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setRequestTarget');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Request::setUri() exists
     */
    public function testRequestSetUriExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('setUri'));
    }

    /**
     * @depends testRequestSetUriExists
     * @testdox Request::setUri() is public
     */
    public function testRequestSetUriIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setUri');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestSetUriExists
     * @testdox Request::setUri() has one required parameter
     */
    public function testRequestSetUriHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'setUri');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRequestSetUriHasOneRequiredParameter
     * @testdox Request::setUri() sets UriInterface
     */
    public function testRequestSetUriSetsUriInterface()
    {
        $url = 'https://shop.example.com/foo/bar/baz-qux';
        $factory = new \StoreCore\LocationFactory();
        $uri = $factory->createUri($url);

        $request = new \StoreCore\Request();
        $request->setUri($uri);
        $this->assertSame($uri, $request->getUri());
    }


    /**
     * @testdox Request::withMethod() exists
     */
    public function testRequestWithMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('withMethod'));
    }

    /**
     * @depends testRequestWithMethodExists
     * @testdox Request::withMethod() is public
     */
    public function testRequestWithMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withMethod');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestWithMethodExists
     * @testdox Request::withMethod() has one required parameter
     */
    public function testRequestWithMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withMethod');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRequestWithMethodExists
     * @expectedException \InvalidArgumentException
     * @testdox Request::withMethod() throws invalid argument exception if HTTP method does not exist
     */
    public function RequestWithMethodThrowsInvalidArgumentExceptionIfHttpMethodDoesNotExist()
    {
        $request = new \StoreCore\Request();
        $instance = $request->withMethod('FOO');
    }

    /**
     * @depends testRequestWithMethodExists
     * @group hmvc
     * @testdox Request::withMethod() returns instance of \StoreCore\Request
     */
    public function testRequestWithMethodReturnsInstanceOfStoreCoreRequest()
    {
        $first_instance = new \StoreCore\Request();
        $first_instance->setMethod('POST');
        $second_instance = $first_instance->withMethod('PATCH');

        $this->assertInstanceOf(\StoreCore\Request::class, $second_instance);
        $this->assertSame('PATCH', $second_instance->getMethod());
        $this->assertNotSame($second_instance->getMethod(), $first_instance->getMethod());
    }


    /**
     * @testdox Request::withRequestTarget() exists
     */
    public function testRequestWithRequestTargetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('withRequestTarget'));
    }

    /**
     * @depends testRequestWithRequestTargetExists
     * @testdox Request::withRequestTarget() is public
     */
    public function testRequestWithRequestTargetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withRequestTarget');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestWithRequestTargetExists
     * @testdox Request::withRequestTarget() has one required parameter
     */
    public function testRequestWithRequestTargetHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withRequestTarget');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRequestWithRequestTargetExists
     * @testdox Request::withRequestTarget() returns instance of Request
     */
    public function testRequestWithRequestTargetReturnsInstanceOfRequest()
    {
        $request = new \StoreCore\Request();
        $this->assertInstanceOf(\StoreCore\Request::class, $request->withRequestTarget('/admin/'));
    }


    /**
     * @testdox Request::withUri() exists
     */
    public function testRequestWithUriExists()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasMethod('withUri'));
    }

    /**
     * @depends testRequestWithUriExists
     * @testdox Request::withUri() is public
     */
    public function testRequestWithUriIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withUri');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestWithUriExists
     * @testdox Request::withUri() has two parameters
     */
    public function testRequestWithUriHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withUri');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testRequestWithUriHasTwoParameters
     * @testdox Request::withUri() has one required parameter
     */
    public function testRequestWithUriHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Request', 'withUri');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRequestWithUriExists
     * @testdox Request::withUri() returns instance of PSR-7 RequestInterface
     */
    public function testRequestWithUriReturnsInstanceOfPsr7RequestInterface()
    {
        $factory = new \StoreCore\LocationFactory();
        $uri = $factory->createUri('https://shop.example.com/foo/bar');
        $request = new \StoreCore\Request();
        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request->withUri($uri));
    }

    /**
     * @depends testRequestWithUriExists
     * @testdox Request::withUri() returns instance of Request
     */
    public function testRequestWithUriReturnsInstanceOfRequest()
    {
        $factory = new \StoreCore\LocationFactory();
        $uri = $factory->createUri('https://shop.example.com/foo/bar');
        $request = new \StoreCore\Request();
        $this->assertInstanceOf(\StoreCore\Request::class, $request->withUri($uri));
    }

    /**
     * @depends testRequestWithUriHasTwoParameters
     * @testdox Request::withUri() $preserveHost test cases
     */
    public function testRequestWithUriPreserveHostTestCases()
    {
        $factory = new \StoreCore\LocationFactory();

        $initial_uri  = $factory->createUri('https://www.example.nl/api/v1/stores');
        $new_uri      = $factory->createUri('https://api.example.com/api/v2/stores');
        $expected_uri = $factory->createUri('https://www.example.nl/api/v2/stores');

        $initial_request = new \StoreCore\Request();
        $initial_request->setUri($initial_uri);

        // Replace host
        $delegated_request = $initial_request->withUri($new_uri);
        $this->assertNotSame($initial_request->getUri(), $delegated_request->getUri());
        $this->assertEquals($new_uri, $delegated_request->getUri());

        // Preserve host
        $delegated_request = $initial_request->withUri($new_uri, true);
        $this->assertNotSame($initial_request->getUri(), $delegated_request->getUri());
        $this->assertEquals($expected_uri, $delegated_request->getUri());
        $this->assertEquals((string) $expected_uri, (string) $delegated_request->getUri());
    }
}
