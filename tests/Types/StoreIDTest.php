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
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\StoreID');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Types\StoreID');
        $class_constant = $class->getConstant('VERSION');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
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
