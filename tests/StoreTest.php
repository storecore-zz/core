<?php
/**
 * @coversDefaultClass \StoreCore\Store
 */
class StoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreStoreModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Store.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public getDateTimeZone() method exists
     */
    public function testPublicGetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('getDateTimeZone'));
    }

    /**
     * @testdox Public getDateTimeZone() method is public
     */
    public function testPublicGetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'getDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getDateTimeZone() method returns string 'UTC' by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsStringUTCByDefault()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertTrue(is_string($object->getDateTimeZone()));
        $this->assertEquals('UTC', $object->getDateTimeZone());
    }

    /**
     * @testdox Public setDateTimeZone() method exists
     */
    public function testPublicSetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('setDateTimeZone'));
    }

    /**
     * @testdox Public setDateTimeZone() method is public
     */
    public function testPublicSetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'setDateTimeZone');
        $this->assertTrue($method->isPublic());
    }
}
