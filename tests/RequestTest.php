<?php
/**
 * @group hmvc
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreRequestClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Request.php');
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
     * @testdox HTTP request method GET is supported
     */
    public function testHttpRequestMethodGetIsSupported()
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $request = new \StoreCore\Request();
        $this->assertEquals('GET', $request->getMethod());
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
}
