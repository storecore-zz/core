<?php
class ServerRequestFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ServerRequestFactory class file exists
     */
    public function testServerRequestFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'ServerRequestFactory.php');
    }

    /**
     * @group hmvc
     * @testdox ServerRequestFactory class is concrete
     */
    public function testServerRequestFactoryClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequestFactory');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Implemented ServerRequestFactoryInterface interface file exists
     */
    public function testImplementedServerRequestFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ServerRequestFactoryInterface.php');
    }

    /**
     * @depends testServerRequestFactoryClassIsConcrete
     * @group hmvc
     * @testdox ServerRequestFactory implements PSR-17 ServerRequestFactoryInterface
     */
    public function testServerRequestFactoryImplementsPsr17ServerRequestFactoryInterface()
    {
        $class = new \StoreCore\ServerRequestFactory('GET', 'https://www.example.com/');
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestFactoryInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequestFactory');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\ServerRequestFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\ServerRequestFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\ServerRequestFactory::VERSION);
    }


    /**
     * @testdox ServerRequestFactory::createServerRequest() exists
     */
    public function testServerRequestFactoryCreateServerRequestExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequestFactory');
        $this->assertTrue($class->hasMethod('createServerRequest'));
    }

    /**
     * @depends testServerRequestFactoryCreateServerRequestExists
     * @testdox ServerRequestFactory::createServerRequest() is public
     */
    public function testServerRequestFactoryCreateServerRequestIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequestFactory', 'createServerRequest');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestFactoryCreateServerRequestExists
     * @testdox ServerRequestFactory::createServerRequest() has three parameters
     */
    public function testServerRequestFactoryCreateServerRequestHasThreeParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequestFactory', 'createServerRequest');
        $this->assertTrue($method->getNumberOfParameters() === 3);
    }

    /**
     * @depends testServerRequestFactoryCreateServerRequestHasThreeParameters
     * @testdox ServerRequestFactory::createServerRequest() has two required parameters
     */
    public function testServerRequestFactoryCreateServerRequestHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequestFactory', 'createServerRequest');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }

    /**
     * @testdox ServerRequestFactory::createServerRequest() returns PSR-7 RequestInterface
     */
    public function testServerRequestFactoryCreateServerRequestReturnsPsr7RequestInterface()
    {
        $factory = new \StoreCore\ServerRequestFactory();
        $this->assertInstanceOf(
            \Psr\Http\Message\ServerRequestInterface::class,
            $factory->createServerRequest('GET', 'https://www.example.com/')
        );
    }
}
