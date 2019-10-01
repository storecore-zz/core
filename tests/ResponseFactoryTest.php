<?php
/**
 * @group hmvc
 */
class ResponseFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreResponseFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'ResponseFactory.php');
    }

    /**
     * @group hmvc
     * @testdox ResponseFactory class is concrete
     */
    public function testResponseFactoryClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\ResponseFactory');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Implemented ResponseFactoryInterface interface file exists
     */
    public function testImplementedResponseFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Http/Message/ResponseFactoryInterface.php');
    }

    /**
     * @depends testResponseFactoryClassIsConcrete
     * @group hmvc
     * @testdox ResponseFactory implements PSR-17 ResponseFactoryInterface
     */
    public function testResponseFactoryImplementsPsr17ResponseFactoryInterface()
    {
        $class = new \StoreCore\ResponseFactory();
        $this->assertInstanceOf(\Psr\Http\Message\ResponseFactoryInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\ResponseFactory');
        $this->assertTrue($class->hasConstant('VERSION'));

    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\ResponseFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\ResponseFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\ResponseFactory::VERSION);
    }


    /**
     * @testdox ResponseFactory::createResponse() exists
     */
    public function testResponseFactoryCreateResponseExists()
    {
        $class = new \ReflectionClass('\StoreCore\ResponseFactory');
        $this->assertTrue($class->hasMethod('createResponse'));
    }

    /**
     * @depends testResponseFactoryCreateResponseExists
     * @testdox ResponseFactory::createResponse() is public
     */
    public function testResponseFactoryCreateResponseIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ResponseFactory', 'createResponse');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testResponseFactoryCreateResponseExists
     * @testdox ResponseFactory::createResponse() has two optional parameters
     */
    public function testResponseFactoryCreateResponseHasTwoOptionalParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ResponseFactory', 'createResponse');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }

    /**
     * @depends testResponseFactoryCreateResponseHasTwoOptionalParameters
     * @group hmvc
     * @testdox ResponseFactory returns PSR-7 ResponseInterface
     */
    public function testResponseFactoryReturnsPsr7ResponseInterface()
    {
        $factory = new \StoreCore\ResponseFactory();
        $response = $factory->createResponse();
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $response);
    }

    /**
     * @depends testResponseFactoryCreateResponseHasTwoOptionalParameters
     * @group hmvc
     * @testdox ResponseFactory returns StoreCore response
     */
    public function testResponseFactoryReturnsStoreCoreresponse()
    {
        $factory = new \StoreCore\ResponseFactory();
        $response = $factory->createResponse();
        $this->assertInstanceOf(\StoreCore\Response::class, $response);
    }
}
