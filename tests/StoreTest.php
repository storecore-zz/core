<?php
/**
 * @coversDefaultClass \StoreCore\Store
 */
class StoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store model class file exists
     */
    public function testStoreModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Store.php');
    }

    /**
     * @group hmvc
     * @testdox Store model extends \StoreCore\AbstractModel
     */
    public function testStoreModelExtendsStoreCoreAbstractModel()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\StoreCore\AbstractModel::class, $store);
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
        $this->assertNotEmpty(\StoreCore\Store::VERSION);
        $this->assertInternalType('string', \StoreCore\Store::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Store::VERSION);
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
     * @testdox Public getDateTimeZone() method has no parameters
     */
    public function testPublicGetDateTimeZoneMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'getDateTimeZone');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Store::getDateTimeZone() returns object
     */
    public function testStoreGetDateTimeZoneReturnsObject()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertInternalType('object', $store->getDateTimeZone());
    }

    /**
     * @testdox Store::getDateTimeZone() returns DateTimeZone object by default
     */
    public function testStoreGetDateTimeZoneReturnsDateTimeZoneObjectByDefault()
    {
        $store = new \StoreCore\Store(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\DateTimeZone::class, $store->getDateTimeZone());
    }

    /**
     * @depends testStoreGetDateTimeZoneReturnsDateTimeZoneObjectByDefault
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
     * @testdox Public getStoreID() method has no parameters
     */
    public function testPublicGetStoreIdMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'getStoreID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
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
     * @testdox Public isSecure() method has no parameters
     */
    public function testPublicIsSecureMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'isSecure');
        $this->assertTrue($method->getNumberOfParameters() === 0);
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
     * @group security
     * @testdox Public setDateTimeZone() method has one parameter
     */
    public function testPublicSetDateTimeZoneMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Store', 'setDateTimeZone');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testStoreGetDateTimeZoneReturnsDateTimeZoneObjectByDefault
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
