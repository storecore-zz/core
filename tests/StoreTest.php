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
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $class_constant = $class->getConstant('VERSION');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @covers ::getDateTimeZone
     * @testdox Public getDateTimeZone() method exists
     */
    public function testPublicGetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('getDateTimeZone'));
    }

    /**
     * @covers ::getDateTimeZone
     * @testdox Public getDateTimeZone() method is public
     */
    public function testPublicGetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'getDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers ::getDateTimeZone
     * @testdox Public getDateTimeZone() method returns object
     */
    public function testPublicGetDateTimeZoneMethodReturnsObject()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $return = $object->getDateTimeZone();
        $this->assertTrue(is_object($return));
    }

    /**
     * @covers ::getDateTimeZone
     * @testdox Public getDateTimeZone() method returns DateTimeZone object by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsDateTimeZoneObjectByDefault()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $return = $object->getDateTimeZone();
        $this->assertTrue($return instanceof \DateTimeZone);
    }

    /**
     * @covers ::getDateTimeZone
     * @depends testPublicGetDateTimeZoneMethodReturnsDateTimeZoneObjectByDefault
     * @testdox Public getDateTimeZone() method returns 'UTC' DateTimeZone by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsUTCDateTimeZoneByDefault()
    {
        $object = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertEquals('UTC', $object->getDateTimeZone()->getName());
    }

    /**
     * @covers \StoreCore\Store::isSecure
     * @group security
     * @testdox Public isSecure() method exists
     */
    public function testPublicIsSecureMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('isSecure'));
    }

    /**
     * @covers \StoreCore\Store::isSecure
     * @group security
     * @testdox Public isSecure() method is public
     */
    public function testPublicIsSecureMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'isSecure');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers \StoreCore\Store::isSecure
     * @group security
     * @testdox Public isSecure() method returns false by default
     */
    public function testPublicIsSecureMethodReturnsFalseByDefault()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertFalse($store->isSecure());
    }

    /**
     * @covers \StoreCore\Store::secure
     * @group security
     * @testdox Public secure() method exists
     */
    public function testPublicSecureMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('secure'));
    }

    /**
     * @covers \StoreCore\Store::secure
     * @group security
     * @testdox Public secure() method is public
     */
    public function testPublicSecureMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'secure');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers ::setDateTimeZone
     * @testdox Public setDateTimeZone() method exists
     */
    public function testPublicSetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Store');
        $this->assertTrue($class->hasMethod('setDateTimeZone'));
    }

    /**
     * @covers ::setDateTimeZone
     * @testdox Public setDateTimeZone() method is public
     */
    public function testPublicSetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'setDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers ::setDateTimeZone
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
