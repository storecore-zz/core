<?php
class RequestStreamTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox RequestStream class file exists
     */
    public function testRequestStreamClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'RequestStream.php');
    }

    /**
     * @depends testRequestStreamClassFileExists
     * @group hmvc
     * @testdox RequestStream class is concrete
     */
    public function testRequestStreamClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\RequestStream');
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
     * @depends testRequestStreamClassIsConcrete
     * @group hmvc
     * @testdox RequestStream extends AbstractStream
     */
    public function testRequestStreamExtendsAbstractStream()
    {
        $class = new \StoreCore\RequestStream();
        $this->assertInstanceOf(\StoreCore\AbstractStream::class, $class);
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
     * @depends testRequestStreamClassIsConcrete
     * @group hmvc
     * @testdox RequestStream implements PSR-7 StreamInterface
     */
    public function testRequestStreamImplementsPsr7StreamInterface()
    {
        $object = new \StoreCore\RequestStream();
        $this->assertInstanceOf(\Psr\Http\Message\StreamInterface::class, $object);
    }


    /**
     * @testdox RequestStream has Writable property
     */
    public function testRequestStreamHasWritableProperty()
    {
        $this->assertClassHasAttribute('Writable', \StoreCore\RequestStream::class);
    }

    /**
     * @testdox RequestStream Writable property is false
     */
    public function testRequestStreamWritablePropertyIsFalse()
    {
        $request_stream = new \StoreCore\RequestStream();
        $this->assertAttributeEquals(false, 'Writable', $request_stream);
    }


    /**
     * @testdox RequestStream::isWritable() exists
     */
    public function testRequestStreamIsWritableExists()
    {
        $class = new \ReflectionClass('\StoreCore\RequestStream');
        $this->assertTrue($class->hasMethod('isWritable'));
    }

    /**
     * @depends testRequestStreamIsWritableExists
     * @testdox RequestStream::isWritable() is public
     */
    public function testRequestStreamIsWritableIsPublic()
    {
        $class = new \ReflectionClass('\StoreCore\RequestStream');
        $this->assertTrue($class->hasMethod('isWritable'));
    }

    /**
     * @depends testRequestStreamIsWritableExists
     * @testdox RequestStream::isWritable() has no parameters
     */
    public function testRequestStreamIsWritableHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\RequestStream', 'isWritable');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testRequestStreamIsWritableHasNoParameters
     * @testdox RequestStream::isWritable() returns false
     */
    public function testRequestStreamIsWritableReturnsFalse()
    {
        $request_stream = new \StoreCore\RequestStream();
        $this->assertFalse($request_stream->isWritable());
    }
}
