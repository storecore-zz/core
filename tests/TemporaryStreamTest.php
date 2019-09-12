<?php
class TemporaryStreamTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox TemporaryStream class file exists
     */
    public function testTemporaryStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'TemporaryStream.php');
    }

    /**
     * @group hmvc
     * @testdox TemporaryStream class is concrete
     */
    public function testTemporaryStreamClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryStream');
        $this->assertFalse($class->isAbstract());
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
     * @testdox TemporaryStream extends AbstractStream
     */
    public function testTemporaryStreamExtendsAbstractStream()
    {
        $stream = new \StoreCore\TemporaryStream();
        $this->assertInstanceOf(\StoreCore\AbstractStream::class, $stream);
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
     * @testdox TemporaryStream implements PSR-7 StreamInterface
     */
    public function testTemporaryStreamImplementsPsr7StreamInterface()
    {
        $stream = new \StoreCore\TemporaryStream();
        $this->assertInstanceOf(\Psr\Http\Message\StreamInterface::class, $stream);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryStream');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\TemporaryStream::VERSION);
        $this->assertInternalType('string', \StoreCore\TemporaryStream::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\TemporaryStream::VERSION);
    }


    /**
     * @testdox TemporaryStream::write() exists
     */
    public function testTemporaryStreamWriteExists()
    {
        $class = new \ReflectionClass('\StoreCore\TemporaryStream');
        $this->assertTrue($class->hasMethod('write'));
    }

    /**
     * @depends testTemporaryStreamWriteExists
     * @testdox TemporaryStream::write() is public
     */
    public function testTemporaryStreamWriteIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\TemporaryStream', 'write');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testTemporaryStreamWriteExists
     * @testdox TemporaryStream::write() has one required parameter
     */
    public function testTemporaryStreamWriteHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\TemporaryStream', 'write');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testTemporaryStreamWriteHasOneRequiredParameter
     * @testdox TemporaryStream::write() returns bytes written as integer
     */
    public function testTemporaryStreamWriteReturnsBytesWrittenAsInteger()
    {
        $stream = new \StoreCore\TemporaryStream();
        $written = $stream->write('Hello world');
        $this->assertEquals(11, $written);
        $this->assertEquals($stream->getSize(), $written);
        $this->assertInternalType('int', $written);
    }
}
