<?php
class FileStreamTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox FileStream class file exists
     */
    public function testFileStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem' . DIRECTORY_SEPARATOR . 'FileStream.php');
    }

    /**
     * @group hmvc
     * @testdox FileStream class is concrete
     */
    public function testFileStreamClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FileStream');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Extended AbstractStream class file exists
     */
    public function testExtendedAbstractStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractStream.php');
    }

    /**
     * @group hmvc
     * @testdox FileStream extends AbstractStream
     */
    public function testFileStreamExtendsAbstractStream()
    {
        $class = new \ReflectionClass(\StoreCore\FileSystem\FileStream::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractStream::class));
    }


    /**
     * @group distro
     * @testdox Implemented PSR-7 StreamInterface interface file exists
     */
    public function testImplementedPsr7StreamInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'StreamInterface.php');
    }

    /**
     * @depends testImplementedPsr7StreamInterfaceInterfaceFileExists
     * @testdox FileStream implements PSR-7 StreamInterface
     */
    public function testFileStreamImplementsPsr7StreamInterface()
    {
        $class = new \ReflectionClass(\StoreCore\FileSystem\FileStream::class);
        $this->assertTrue($class->isSubclassOf(\Psr\Http\Message\StreamInterface::class));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FileStream');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\FileStream::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\FileStream::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\FileStream::VERSION);
    }


    /**
     * @testdox FileStream::__construct() exists
     */
    public function testFileStreamConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FileStream');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testFileStreamConstructExists
     * @testdox FileStream::__construct() is public
     */
    public function testFileStreamConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FileStream', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testFileStreamConstructExists
     * @testdox FileStream::__construct() has two parameters
     */
    public function testFileStreamConstructorHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FileStream', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testFileStreamConstructorHasTwoParameters
     * @testdox FileStream::__construct() has one required parameter
     */
    public function testFileStreamConstructorHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FileStream', '__construct');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox FileStream::write() exists
     */
    public function testFileStreamWriteExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\FileStream');
        $this->assertTrue($class->hasMethod('write'));
    }

    /**
     * @depends testFileStreamWriteExists
     * @testdox FileStream::write() is public
     */
    public function testFileStreamWriteIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FileStream', 'write');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testFileStreamWriteExists
     * @testdox FileStream::write() has one required parameter
     */
    public function testFileStreamWriteHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\FileStream', 'write');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
