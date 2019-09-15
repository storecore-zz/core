<?php
class TemporaryMemoryStreamTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox TemporaryMemoryStream class file exists
     */
    public function testTemporaryMemoryStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'TemporaryMemoryStream.php');
    }

    /**
     * @group hmvc
     * @testdox TemporaryMemoryStream class is concrete
     */
    public function testTemporaryMemoryStreamClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryMemoryStream');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Extended TemporaryMemory class file exists
     */
    public function testExtendedTemporaryStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'TemporaryStream.php');
    }

    /**
     * @group hmvc
     * @testdox TemporaryMemoryStream extends TemporaryStream
     */
    public function testTemporaryMemoryStreamExtendsTemporaryStream()
    {
        $stream = new \StoreCore\TemporaryMemoryStream();
        $this->assertInstanceOf(\StoreCore\TemporaryStream::class, $stream);
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
     * @group hmvc
     * @depends testImplementedPsr7StreamInterfaceInterfaceFileExists
     * @testdox TemporaryMemoryStream implements PSR-7 StreamInterface
     */
    public function testTemporaryMemoryStreamImplementsPsr7StreamInterface()
    {
        $class = new \ReflectionClass('\Psr\Http\Message\StreamInterface');
        $this->assertTrue($class->isInterface());

        $stream = new \StoreCore\TemporaryMemoryStream();
        $this->assertInstanceOf(\Psr\Http\Message\StreamInterface::class, $stream);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryMemoryStream');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\TemporaryMemoryStream::VERSION);
        $this->assertInternalType('string', \StoreCore\TemporaryMemoryStream::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\TemporaryMemoryStream::VERSION);
    }


    /**
     * @group hmvc
     * @testdox FILENAME constant is defined
     */
    public function testFilenameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryMemoryStream');
        $this->assertTrue($class->hasConstant('FILENAME'));
    }

    /**
     * @depends testFilenameConstantIsDefined
     * @group hmvc
     * @testdox FILENAME constant equals 'php://memory'
     */
    public function testFilenameConstantEqualsPhpMemory()
    {
        $this->assertEquals('php://memory', \StoreCore\TemporaryMemoryStream::FILENAME);
    }

    /**
     * @group hmvc
     * @testdox MODE constant is defined
     */
    public function testModeConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryMemoryStream');
        $this->assertTrue($class->hasConstant('MODE'));
    }

    /**
     * @depends testModeConstantIsDefined
     * @group hmvc
     * @testdox MODE constant equals 'r+' for read-write
     */
    public function testFilenameConstantEqualsRPlusForReadWrite()
    {
        $this->assertEquals('r+', \StoreCore\TemporaryMemoryStream::MODE);
    }
}
