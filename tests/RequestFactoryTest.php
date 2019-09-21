<?php
class RequestFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox RequestFactory class file exists
     */
    public function testRequestFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'RequestFactory.php');
    }

    /**
     * @group hmvc
     * @testdox RequestFactory class is concrete
     */
    public function testRequestFactoryClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\RequestFactory');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Implemented RequestFactoryInterface interface file exists
     */
    public function testImplementedRequestFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'RequestFactoryInterface.php');
    }

    /**
     * @depends testRequestFactoryClassIsConcrete
     * @group hmvc
     * @testdox RequestFactory implements PSR-17 RequestFactoryInterface
     */
    public function testRequestFactoryImplementsPsr17RequestFactoryInterface()
    {
        $class = new \StoreCore\RequestFactory('GET', 'https://www.example.com/');
        $this->assertInstanceOf(\Psr\Http\Message\RequestFactoryInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\RequestFactory');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\RequestFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\RequestFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\RequestFactory::VERSION);
    }


    /**
     * @testdox RequestFactory::createRequest() exists
     */
    public function testRequestFactoryCreateRequestExists()
    {
        $class = new \ReflectionClass('\StoreCore\RequestFactory');
        $this->assertTrue($class->hasMethod('createRequest'));
    }

    /**
     * @depends testRequestFactoryCreateRequestExists
     * @testdox RequestFactory::createRequest() is public
     */
    public function testRequestFactoryCreateRequestIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\RequestFactory', 'createRequest');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRequestFactoryCreateRequestExists
     * @testdox RequestFactory::createRequest() has two required parameters
     */
    public function testRequestFactoryCreateRequestHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\RequestFactory', 'createRequest');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }

    /**
     * @testdox RequestFactory::createRequest() returns PSR-7 RequestInterface
     */
    public function testRequestFactoryCreateRequestReturnsPsr7RequestInterface()
    {
        $factory = new \StoreCore\RequestFactory();
        $this->assertInstanceOf(
            \Psr\Http\Message\RequestInterface::class,
            $factory->createRequest('GET', 'https://www.example.com/')
        );
    }
}
