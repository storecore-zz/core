<?php
/**
 * @group hmvc
 */
class StreamFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox StreamFactory class file exists
     */
    public function testStreamFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StreamFactory.php');
    }

    /**
     * @testdox StreamFactory is concrete
     */
    public function testStreamFactoryIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\StreamFactory');
        $this->assertFalse($class->isAbstract());
    }


    /**
     * @group distro
     * @testdox Implemented PSR-17 StreamFactoryInterface interface file exists
     */
    public function testImplementedPsr17StreamFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'StreamFactoryInterface.php');
    }

    /**
     * @depends testImplementedPsr17StreamFactoryInterfaceInterfaceFileExists
     * @testdox StreamFactory implements StreamFactoryInterface
     */
    public function testStreamFactoryImplementsStreamFactoryInterface()
    {
        $factory = new \StoreCore\StreamFactory();
        $this->assertInstanceOf(\Psr\Http\Message\StreamFactoryInterface::class, $factory);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StreamFactory');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\StreamFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\StreamFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\StreamFactory::VERSION);
    }


    /**
     * @testdox StreamFactory::createStream() exists
     */
    public function testStreamFactoryCreateStreamExists()
    {
        $class = new \ReflectionClass('\StoreCore\StreamFactory');
        $this->assertTrue($class->hasMethod('createStream'));
    }

    /**
     * @depends testStreamFactoryCreateStreamExists
     * @testdox StreamFactory::createStream() is public
     */
    public function testStreamFactoryCreateStreamIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStream');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testStreamFactoryCreateStreamExists
     * @testdox StreamFactory::createStream() has one optional parameter
     */
    public function testStreamFactoryCreateStreamHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStream');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }

    /**
     * @depends testStreamFactoryCreateStreamHasOneOptionalParameter
     * @testdox StreamFactory::createStream() returns PSR-7 StreamInterface
     */
    public function testStreamFactoryCreateStreamReturnsPsr7StreamInterface()
    {
        $factory = new \StoreCore\StreamFactory();
        $stream = $factory->createStream();
        $this->assertInstanceOf(\Psr\Http\Message\StreamInterface::class, $stream);
    }


    /**
     * @testdox StreamFactory::createStreamFromFile() exists
     */
    public function testStreamFactoryCreateStreamFromFileExists()
    {
        $class = new \ReflectionClass('\StoreCore\StreamFactory');
        $this->assertTrue($class->hasMethod('createStreamFromFile'));
    }

    /**
     * @depends testStreamFactoryCreateStreamFromFileExists
     * @testdox StreamFactory::createStreamFromFile() is public
     */
    public function testStreamFactoryCreateStreamFromFileIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStreamFromFile');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testStreamFactoryCreateStreamFromFileExists
     * @testdox StreamFactory::createStreamFromFile() has two parameters
     */
    public function testStreamFactoryCreateStreamFromFileHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStreamFromFile');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testStreamFactoryCreateStreamFromFileHasTwoParameters
     * @testdox StreamFactory::createStreamFromFile() has one required parameter
     */
    public function testStreamFactoryCreateStreamFromFileHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\StreamFactory', 'createStreamFromFile');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
