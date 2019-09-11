<?php
class AbstractStreamTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AbstractStream class file exists
     */
    public function testAbstractStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractStream.php');
    }

    /**
     * @depends testAbstractStreamClassFileExists
     * @testdox AbstractStream is abstract
     */
    public function testAbstractStreamIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\AbstractStream');
        $this->assertTrue($class->isAbstract());
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
     * @group distro
     * @testdox AbstractStream implements PSR-7 StreamInterface
     */
    public function testAbstractStreamImplementsPsr7StreamInterface()
    {
        $stub = $this->getMock(\StoreCore\AbstractStream::class);
        $this->assertInstanceOf(\Psr\Http\Message\StreamInterface::class, $stub);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AbstractStream');
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
        $this->assertInternalType('string', \StoreCore\AbstractStream::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AbstractStream::VERSION);
    }
}
