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

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Request');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
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
}
