<?php
class StoreIDTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Core store ID class file exists
     */
    public function testCoreStoreIdClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'StoreID.php');
    }

    /**
     * @group distro
     */
    public function testExtendedTinyintUnsignedClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'TinyintUnsigned.php');
    }

    /**
     * @group hmvc
     * @testdox Class implements StringableInterface
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Types\StoreID();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }

    /**
     * @group hmvc
     * @testdox Class implements TypeInterface
     */
    public function testClassImplementsTypeInterface()
    {
        $object = new \StoreCore\Types\StoreID();
        $this->assertInstanceOf(\StoreCore\Types\TypeInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\StoreID');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\StoreID::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\StoreID::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\StoreID::VERSION);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsInvalidArgumentExceptionOnString()
    {
        $object = new \StoreCore\Types\StoreID('FooBar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsInvalidArgumentExceptionOnNumericString()
    {
        $object = new \StoreCore\Types\StoreID('1');
    }

    /**
     * @expectedException \DomainException
     */
    public function testThrowsLowerBoundDomainException()
    {
        $object = new \StoreCore\Types\StoreID(0);
    }

    /**
     * @expectedException \DomainException
     */
    public function testThrowsUpperBoundDomainException()
    {
        $object = new \StoreCore\Types\StoreID(256);
    }

    public function testFullValueRangeAsStrings()
    {
        for ($i = 1; $i <= 255; $i++) {
            $object = new \StoreCore\Types\StoreID($i);
            $string = (string)$object;
            $this->assertEquals($i, $string);
        }
    }
}
