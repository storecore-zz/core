<?php
/**
 * @group hmvc
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreResponseClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Response.php');
    }

    /**
     * @group hmvc
     * @testdox Response class is concrete
     */
    public function testResponseClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasConstant('VERSION'));

    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Response::VERSION);
        $this->assertInternalType('string', \StoreCore\Response::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Response::VERSION);
    }

    /**
     * @testdox Response::getReasonPhrase() exists
     */
    public function testResponseGetReasonPhraseExists()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasMethod('getReasonPhrase'));
    }

    /**
     * @depends testResponseGetReasonPhraseExists
     * @testdox Response::getReasonPhrase() is public
     */
    public function testResponseGetReasonPhraseIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'getReasonPhrase');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseGetReasonPhraseExists
     * @testdox Response::getReasonPhrase() has no parameters
     */
    public function testResponseGetReasonPhraseHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'getReasonPhrase');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testResponseGetReasonPhraseHasNoParameters
     * @testdox Response::getReasonPhrase() returns non-empty string
     */
    public function testResponseGetReasonPhraseReturnsNonEmptyString()
    {
        $response = new \StoreCore\Response();
        $this->assertNotEmpty($response->getReasonPhrase());
        $this->assertInternalType('string', $response->getReasonPhrase());
    }

    /**
     * @depends testResponseGetReasonPhraseReturnsNonEmptyString
     * @testdox Response::getReasonPhrase() returns 'OK' by default
     */
    public function testResponseGetReasonPhraseReturnsOkByDefault()
    {
        $response = new \StoreCore\Response();
        $this->assertEquals('OK', $response->getReasonPhrase());
    }


    /**
     * @testdox Response::getStatusCode exists
     */
    public function testResponseGetStatusCodeExists()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasMethod('getStatusCode'));
    }

    /**
     * @depends testResponseGetStatusCodeExists
     * @testdox Response::getStatusCode() is public
     */
    public function testResponseGetStatusCodeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'getStatusCode');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseGetStatusCodeExists
     * @testdox Response::getStatusCode() has no parameters
     */
    public function testResponseGetStatusCodeHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'getStatusCode');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testResponseGetStatusCodeHasNoParameters
     * @testdox Response::getStatusCode() returns integer
     */
    public function testResponseGetStatusCodeReturnsInteger()
    {
        $response = new \StoreCore\Response();
        $this->assertInternalType('int', $response->getStatusCode());
    }

    /**
     * @depends testResponseGetStatusCodeReturnsInteger
     * @testdox Response::getStatusCode() returns 200 by default
     */
    public function testResponseGetStatusCodeReturns200ByDefault()
    {
        $response = new \StoreCore\Response();
        $this->assertEquals(200, $response->getStatusCode());
    }


    /**
     * @testdox Response::setStatusCode() exists
     */
    public function testResponseSetStatusCodeExists()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasMethod('setStatusCode'));
    }

    /**
     * @depends testResponseSetStatusCodeExists
     * @testdox Response::setStatusCode() is public
     */
    public function testResponseSetStatusCodeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'setStatusCode');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseSetStatusCodeExists
     * @testdox Response::setStatusCode() has one required parameter
     */
    public function testResponseSetStatusCodeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'setStatusCode');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Response::setReasonPhrase() exists
     */
    public function testResponseSetReasonPhraseExists()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasMethod('setReasonPhrase'));
    }

    /**
     * @depends testResponseSetReasonPhraseExists
     * @testdox Response::setReasonPhrase() is public
     */
    public function testResponseSetReasonPhraseIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'setReasonPhrase');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseSetReasonPhraseExists
     * @testdox Response::setReasonPhrase() has one required parameter
     */
    public function testResponseSetReasonPhraseHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'setReasonPhrase');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Response::withStatus() exists
     */
    public function testResponseWithStatusExists()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasMethod('withStatus'));
    }

    /**
     * @depends testResponseWithStatusExists
     * @testdox Response::withStatus() is public
     */
    public function testResponseWithStatusIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'withStatus');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseWithStatusExists
     * @testdox Response::withStatus() has two parameters
     */
    public function testResponseWithStatusHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'withStatus');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testResponseWithStatusHasTwoParameters
     * @testdox Response::withStatus() has one required parameter
     */
    public function testResponseWithStatusHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Response', 'withStatus');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
