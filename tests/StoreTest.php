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
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Store::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Store::VERSION));
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
     * @testdox Public getDateTimeZone() method returns object
     */
    public function testPublicGetDateTimeZoneMethodReturnsObject()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $return = $object->getDateTimeZone();
        $this->assertTrue(is_object($return));
    }

    /**
     * @testdox Public getDateTimeZone() method returns DateTimeZone object by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsDateTimeZoneObjectByDefault()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $return = $object->getDateTimeZone();
        $this->assertTrue($return instanceof \DateTimeZone);
    }

    /**
     * @depends testPublicGetDateTimeZoneMethodReturnsDateTimeZoneObjectByDefault
     * @testdox Public getDateTimeZone() method returns 'UTC' DateTimeZone by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsUTCDateTimeZoneByDefault()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertEquals('UTC', $object->getDateTimeZone()->getName());
    }

    /**
     * @group hmvc
     * @testdox Public getStoreID() method exists
     */
    public function testPublicgetStoreIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('getStoreID'));
    }

    /**
     * @group hmvc
     * @testdox Public getStoreID() method is public
     */
    public function testPublicGetStoreIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'getStoreID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group hmvc
     * @testdox Public getStoreID() method returns null by default
     */
    public function testPublicGetStoreIDMethodReturnsNullByDefault()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertNull($store->getStoreID());
    }

    /**
     * @group security
     * @testdox Public isSecure() method exists
     */
    public function testPublicIsSecureMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('isSecure'));
    }

    /**
     * @group security
     * @testdox Public isSecure() method is public
     */
    public function testPublicIsSecureMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'isSecure');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @group security
     * @testdox Public isSecure() method returns false by default
     */
    public function testPublicIsSecureMethodReturnsFalseByDefault()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertFalse($store->isSecure());
    }

    /**
     * @group security
     * @testdox Public secure() method exists
     */
    public function testPublicSecureMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('secure'));
    }

    /**
     * @group security
     * @testdox Public secure() method is public
     */
    public function testPublicSecureMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'secure');
        $this->assertTrue($method->isPublic());
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

    /**
     * @depends testPublicGetDateTimeZoneMethodReturnsDateTimeZoneObjectByDefault
     * @testdox Public setDateTimeZone() method accepts common timezone identifiers
     */
    public function testPublicSetDateTimeZoneMethodAcceptsCommonTimezoneIdentifiers()
    {
        $timezone_identifiers = array(
            'America/Los_Angeles',
            'America/New_York',
            'Europe/Amsterdam',
            'Europe/Brussels',
            'Europe/Berlin',
            'Europe/London',
            'Europe/Paris',
            'UTC',
        );

        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        foreach ($timezone_identifiers as $timezone_identifier) {
            $store->setDateTimeZone($timezone_identifier);
            $this->assertEquals($timezone_identifier, $store->getDateTimeZone()->getName());
        }
    }
}
