<?php
/**
 * @group security
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreUserModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'User.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public authenticate() method exists
     */
    public function testPublicAuthenticateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('authenticate'));
    }

    /**
     * @testdox Public authenticate() method is public
     */
    public function testPublicAuthenticateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'authenticate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public authenticate($password) method has one required parameter
     */
    public function testPublicAuthenticateMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'authenticate');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox Public getDateTimeZone() method exists
     */
    public function testPublicGetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getDateTimeZone'));
    }

    /**
     * @testdox Public getDateTimeZone() method is public
     */
    public function testPublicGetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getDateTimeZone() method returns string 'UTC' by default
     */
    public function testPublicGetDateTimeZoneMethodReturnsStringUTCByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertTrue(is_string($object->getDateTimeZone()));
        $this->assertEquals('UTC', $object->getDateTimeZone());
    }

    /**
     * @testdox Public getEmailAddress() method exists
     */
    public function testPublicGetEmailAddressMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getEmailAddress'));
    }

    /**
     * @testdox Public getEmailAddress() method is public
     */
    public function testPublicGetEmailAddressMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getEmailAddress');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getHashAlgorithm() method exists
     */
    public function testPublicGetHashAlgorithmMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getHashAlgorithm'));
    }

    /**
     * @testdox Public getHashAlgorithm() method is public
     */
    public function testPublicGetHashAlgorithmMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getHashAlgorithm');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getLanguageID() method exists
     */
    public function testPublicGetLanguageIDMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getLanguageID'));
    }

    /**
     * @testdox Public getLanguageID() method is public
     */
    public function testPublicGetLanguageIDMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getLanguageID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getLanguageID() method returns string 'en-GB' by default
     */
    public function testPublicGetLanguageIDMethodReturnsStringForBritishEnglishByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertTrue(is_string($object->getLanguageID()));
        $this->assertEquals('en-GB', $object->getLanguageID());
    }

    /**
     * @testdox Public getPasswordHash() method exists
     */
    public function testPublicGetPasswordHashMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPasswordHash'));
    }

    /**
     * @testdox Public getPasswordHash() method is public
     */
    public function testPublicGetPasswordHashMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordHash');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getPasswordSalt() method exists
     */
    public function testPublicGetPasswordSaltMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPasswordSalt'));
    }

    /**
     * @testdox Public getPasswordSalt() method is public
     */
    public function testPublicGetPasswordSaltMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordSalt');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getPersonID() method exists
     */
    public function testPublicGetPersonIDMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPersonID'));
    }

    /**
     * @testdox Public getPersonID() method is public
     */
    public function testPublicGetPersonIDMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPersonID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getPersonID() method returns null by default
     */
    public function testPublicGetPersonIDMethodReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getPersonID());
    }

    /**
     * @testdox Public getPIN() method exists
     */
    public function testPublicGetPINMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPIN'));
    }

    /**
     * @testdox Public getPIN() method is public
     */
    public function testPublicGetPINMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPIN');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getPIN() method returns string '0000' by default
     */
    public function testPublicGetPINMethodReturnsString0000ByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertTrue(is_string($object->getPIN()));
        $this->assertEquals('0000', $object->getPIN());
    }

    /**
     * @testdox Public getUserGroupID() method exists
     */
    public function testPublicGetUserGroupIDMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUserGroupID'));
    }

    /**
     * @testdox Public getUserGroupID() method is public
     */
    public function testPublicGetUserGroupIDMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserGroupID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUserGroupID() method returns int 0 by default
     */
    public function testPublicGetUserGroupIDMethodReturnsInt0ByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertTrue(is_int($object->getUserGroupID()));
        $this->assertEquals(0, $object->getUserGroupID());
    }

    /**
     * @testdox Public getUserID() method exists
     */
    public function testPublicGetUserIDMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUserID'));
    }

    /**
     * @testdox Public getUserID() method is public
     */
    public function testPublicGetUserIDMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUserID() method returns null by default
     */
    public function testPublicGetUserIDMethodReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getUserID());
    }

    /**
     * @testdox Public getUsername() method exists
     */
    public function testPublicGetUsernameMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUsername'));
    }

    /**
     * @testdox Public getUsername() method is public
     */
    public function testPublicGetUsernameMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUsername');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUsername() method returns null by default
     */
    public function testPublicGetUsernameMethodReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getUsername());
    }

    /**
     * @testdox Public setDateTimeZone() method exists
     */
    public function testPublicSetDateTimeZoneMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setDateTimeZone'));
    }

    /**
     * @testdox Public setDateTimeZone() method is public
     */
    public function testPublicSetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setDateTimeZone() method returns string 'UTC' on non-existent timezone
     */
    public function testPublicSetDateTimeZoneMethodReturnsStringUTCOnNonExistentTimezone()
    {
        $object = new \StoreCore\User();
        $this->assertTrue(is_string($object->setDateTimeZone('Foo/Bar')));
        $this->assertEquals('UTC', $object->setDateTimeZone('Foo/Bar'));
    }

    /**
     * @testdox Public setDateTimeZone() method returns set timezone
     */
    public function testPublicSetDateTimeZoneMethodReturnsSetTimezone()
    {
        $object = new \StoreCore\User();
        $this->assertEquals('Europe/Amsterdam', $object->setDateTimeZone('Europe/Amsterdam'));
        $this->assertEquals('Europe/Amsterdam', $object->getDateTimeZone());
    }

    /**
     * @testdox Public setPasswordHash() method exists
     */
    public function testPublicSetPasswordHashMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPasswordHash'));
    }

    /**
     * @testdox Public setPasswordHash() method is public
     */
    public function testPublicSetPasswordHashMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPasswordHash');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setPasswordSalt() method exists
     */
    public function testPublicSetPasswordSaltMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPasswordSalt'));
    }

    /**
     * @testdox Public setPasswordSalt() method is public
     */
    public function testPublicSetPasswordSaltMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPasswordSalt');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setPersonID() method exists
     */
    public function testPublicSetPersonIDMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPersonID'));
    }

    /**
     * @testdox Public setPersonID() method is public
     */
    public function testPublicSetPersonIDMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPersonID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setPIN() method exists
     */
    public function testPublicSetPINMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPIN'));
    }

    /**
     * @testdox Public setPIN() method is public
     */
    public function testPublicSetPINMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPIN');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @expectedException \UnexpectedValueException
     * @testdox Public setPIN() method throws \UnexpectedValueException on letters
     */
    public function testPublicSetPINMethodThrowsUnexpectedValueExceptionOnLetters()
    {
        $object = new \StoreCore\User();
        $object->setPIN('ABCD');
    }

    /**
     * @testdox Public setUserGroupID() method exists
     */
    public function testPublicSetUserGroupIDExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUserGroupID'));
    }

    /**
     * @testdox Public setUserGroupID() method is public
     */
    public function testPublicSetUserGroupIDIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserGroupID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setUserGroupID() method throws \DomainException on tinyint less than 0
     */
    public function testPublicSetUserGroupIDMethodThrowsDomainExceptionOnTinyintLessThanZero()
    {
        $object = new \StoreCore\User();
        $object->setUserGroupID(-1);
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setUserGroupID() method throws \DomainException on tinyint greater than 255
     */
    public function testPublicSetUserGroupIDMethodThrowsDomainExceptionOnTinyintGreaterThan255()
    {
        $object = new \StoreCore\User();
        $object->setUserGroupID(256);
    }

    /**
     * @testdox Public setUserID() method exists
     */
    public function testPublicSetUserIDExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUserID'));
    }

    /**
     * @testdox Public setUserID() method is public
     */
    public function testPublicSetUserIDIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setUsername() method exists
     */
    public function testPublicSetUsernameExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUsername'));
    }

    /**
     * @testdox Public setUsername() method is public
     */
    public function testPublicSetUsernameIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUsername');
        $this->assertTrue($method->isPublic());
    }
}
