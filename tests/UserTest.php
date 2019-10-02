<?php
/**
 * @coversDefaultClass \StoreCore\User
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
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\User::VERSION);
        $this->assertInternalType('string', \StoreCore\User::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\User::VERSION);
    }


    /**
     * @testdox User::authenticate() exists
     */
    public function testUserAuthenticateExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('authenticate'));
    }

    /**
     * @testdox User::authenticate() is public
     */
    public function testUserAuthenticateIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'authenticate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::authenticate() has one required parameter
     */
    public function testUserAuthenticateHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'authenticate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox User::authenticate() returns bool false by default
     */
    public function testUserAuthenticateReturnsBoolFalseByDefault()
    {
        $user = new \StoreCore\User();
        $password = 'TopSecret';
        $this->assertInternalType('bool', $user->authenticate($password));
        $this->assertFalse($user->authenticate($password));
    }


    /**
     * @testdox User::getDateTimeZone() exists
     */
    public function testUserGetDateTimeZoneExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getDateTimeZone'));
    }

    /**
     * @depends testUserGetDateTimeZoneExists
     * @testdox User::getDateTimeZone() is public
     */
    public function testUserGetDateTimeZoneIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testUserGetDateTimeZoneExists
     * @testdox User::getDateTimeZone() has no parameters
     */
    public function testUserGetDateTimeZoneHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getDateTimeZone');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getDateTimeZone() returns object
     */
    public function testUserGetDateTimeZoneReturnsObject()
    {
        $user = new \StoreCore\User();
        $this->assertInternalType('object', $user->getDateTimeZone());
    }

    /**
     * @testdox User::getDateTimeZone() returns DateTimeZone object by default
     */
    public function testUserGetDateTimeZoneReturnsDateTimeZoneObjectByDefault()
    {
        $user = new \StoreCore\User();
        $this->assertInstanceOf(\DateTimeZone::class, $user->getDateTimeZone());
    }

    /**
     * @depends testUserGetDateTimeZoneReturnsDateTimeZoneObjectByDefault
     * @testdox User::getDateTimeZone() returns 'UTC' DateTimeZone by default
     */
    public function testUserGetDateTimeZoneReturnsUTCDateTimeZoneByDefault()
    {
        $user = new \StoreCore\User();
        $this->assertEquals('UTC', $user->getDateTimeZone()->getName());
    }


    /**
     * @testdox User::getEmailAddress() exists
     */
    public function testUserGetEmailAddressExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getEmailAddress'));
    }

    /**
     * @testdox User::getEmailAddress() is public
     */
    public function testUserGetEmailAddressIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getEmailAddress');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getEmailAddress() has no parameters
     */
    public function testUserGetEmailAddressHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getEmailAddress');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox User::getHashAlgorithm() exists
     */
    public function testUserGetHashAlgorithmExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getHashAlgorithm'));
    }

    /**
     * @testdox User::getHashAlgorithm() is public
     */
    public function testUserGetHashAlgorithmIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getHashAlgorithm');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getHashAlgorithm() has no parameters
     */
    public function testUserGetHashAlgorithmHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getHashAlgorithm');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getHashAlgorithm() returns null by default
     */
    public function testUserGetHashAlgorithmReturnsNullByDefault()
    {
        $user = new \StoreCore\User();
        $this->assertNull($user->getHashAlgorithm());
    }


    /**
     * @testdox User::getLanguageID() exists
     */
    public function testUserGetLanguageIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getLanguageID'));
    }

    /**
     * @testdox User::getLanguageID() is public
     */
    public function testUserGetLanguageIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getLanguageID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getLanguageID() has no parameters
     */
    public function testUserGetLanguageIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getLanguageID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getLanguageID() returns string 'en-GB' by default
     */
    public function testUserGetLanguageIdReturnsStringForBritishEnglishByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertInternalType('string', $object->getLanguageID());
        $this->assertEquals('en-GB', $object->getLanguageID());
    }


    /**
     * @testdox User::getPasswordHash() exists
     */
    public function testUserGetPasswordHashExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPasswordHash'));
    }

    /**
     * @testdox User::getPasswordHash() is public
     */
    public function testUserGetPasswordHashIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordHash');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getPasswordHash() has no parameters
     */
    public function testUserGetPasswordHashHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordHash');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox User::getPasswordSalt() exists
     */
    public function testUserGetPasswordSaltExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPasswordSalt'));
    }

    /**
     * @testdox User::getPasswordSalt() is public
     */
    public function testUserGetPasswordSaltIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordSalt');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getPasswordSalt() has no parameters
     */
    public function testUserGetPasswordSaltHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPasswordSalt');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox User::getPersonID() exists
     */
    public function testUserGetPersonIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPersonID'));
    }

    /**
     * @testdox User::getPersonID() is public
     */
    public function testUserGetPersonIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPersonID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getPersonID() has no parameters
     */
    public function testUserGetPersonIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPersonID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getPersonID() returns null by default
     */
    public function testUserGetPersonIdReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getPersonID());
    }


    /**
     * @testdox User::getPIN() exists
     */
    public function testUserGetPinExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getPIN'));
    }

    /**
     * @testdox User::getPIN() is public
     */
    public function testUserGetPinIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPIN');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getPIN() has no parameters
     */
    public function testUserGetPinHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getPIN');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getPIN() returns string '0000' by default
     */
    public function testUserGetPinReturnsString0000ByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertInternalType('string', $object->getPIN());
        $this->assertEquals('0000', $object->getPIN());
    }


    /**
     * @testdox User::getUserGroupID() exists
     */
    public function testUserGetUserGroupIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUserGroupID'));
    }

    /**
     * @testdox User::getUserGroupID() is public
     */
    public function testUserGetUserGroupIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserGroupID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getUserGroupID() has no parameters
     */
    public function testUserGetUserGroupIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserGroupID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getUserGroupID() returns int 0 by default
     */
    public function testUserGetUserGroupIdReturnsInt0ByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertInternalType('int', $object->getUserGroupID());
        $this->assertEquals(0, $object->getUserGroupID());
    }


    /**
     * @testdox User::getUserID() exists
     */
    public function testUserGetUserIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUserID'));
    }

    /**
     * @testdox User::getUserID() is public
     */
    public function testUserGetUserIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getUserID() has no parameters
     */
    public function testUserGetUserIdHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUserID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getUserID() returns null by default
     */
    public function testUserGetUserIdReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getUserID());
    }


    /**
     * @testdox User::getUsername() exists
     */
    public function testUserGetUsernameExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('getUsername'));
    }

    /**
     * @testdox User::getUsername() is public
     */
    public function testUserGetUsernameIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUsername');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::getUsername() has no parameters
     */
    public function testUserGetUsernameHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'getUsername');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox User::getUsername() returns null by default
     */
    public function testUserGetUsernameReturnsNullByDefault()
    {
        $object = new \StoreCore\User();
        $this->assertNull($object->getUsername());
    }


    /**
     * @testdox User::setDateTimeZone() exists
     */
    public function testUserSetDateTimeZoneExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setDateTimeZone'));
    }

    /**
     * @testdox User::setDateTimeZone() is public
     */
    public function testPublicSetDateTimeZoneMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setDateTimeZone');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::setDateTimeZone() has one required parameter
     */
    public function testStreamFactoryCreateStreamFromResourceHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setDateTimeZone');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testUserGetDateTimeZoneReturnsDateTimeZoneObjectByDefault
     * @testdox User::setDateTimeZone() accepts global 'UTC' DateTimeZone
     */
    public function testUserSetDateTimeZoneAcceptsGlobalUtcDateTimeZone()
    {
        $timezone_string = 'UTC';
        $timezone_object = new \DateTimeZone($timezone_string);
        $user = new \StoreCore\User();
        $user->setDateTimeZone($timezone_object);
        $this->assertSame($timezone_object, $user->getDateTimeZone());
        $this->assertSame($timezone_string, $user->getDateTimeZone()->getName());
    }


    /**
     * @testdox User::setPasswordHash() exists
     */
    public function testUserSetPasswordHashExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPasswordHash'));
    }

    /**
     * @testdox User::setPasswordHash() is public
     */
    public function testUserSetPasswordHashIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPasswordHash');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox User::setPasswordSalt() exists
     */
    public function testUserSetPasswordSaltExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPasswordSalt'));
    }

    /**
     * @testdox User::setPasswordSalt() is public
     */
    public function testUserSetPasswordSaltIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPasswordSalt');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox User::setPersonID() exists
     */
    public function testUserSetPersonIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPersonID'));
    }

    /**
     * @testdox User::setPersonID() is public
     */
    public function testUserSetPersonIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPersonID');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox User::setPIN() exists
     */
    public function testUserSetPinExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setPIN'));
    }

    /**
     * @testdox User::setPIN() is public
     */
    public function testUserSetPinIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setPIN');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @expectedException \UnexpectedValueException
     * @testdox User::setPIN() throws \UnexpectedValueException on letters
     */
    public function testUserSetPinThrowsUnexpectedValueExceptionOnLetters()
    {
        $object = new \StoreCore\User();
        $object->setPIN('ABCD');
    }


    /**
     * @testdox User::setUserGroupID() exists
     */
    public function testUserSetUserGroupIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUserGroupID'));
    }

    /**
     * @testdox User::setUserGroupID() is public
     */
    public function testUserSetUserGroupIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserGroupID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::setUserGroupID() has one required parameter
     */
    public function testUserSetUserGroupIdHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserGroupID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox User::setUserGroupID() requires integer
     */
    public function testUserSetUserGroupIdRequiresInteger()
    {
        $user = new \StoreCore\User();
        $user->setUserGroupID(1.2);
    }

    /**
     * @expectedException \DomainException
     * @testdox User::setUserGroupID() throws \DomainException on tinyint less than 0
     */
    public function testUserSetUserGroupIdThrowsDomainExceptionOnTinyintLessThanZero()
    {
        $object = new \StoreCore\User();
        $object->setUserGroupID(-1);
    }

    /**
     * @expectedException \DomainException
     * @testdox User::setUserGroupID() throws \DomainException on tinyint greater than 255
     */
    public function testUserSetUserGroupIdThrowsDomainExceptionOnTinyintGreaterThan255()
    {
        $object = new \StoreCore\User();
        $object->setUserGroupID(256);
    }


    /**
     * @testdox User::setUserID() exists
     */
    public function testUserSetUserIdExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUserID'));
    }

    /**
     * @testdox User::setUserID() is public
     */
    public function testUserSetUserIdIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::setUserID() has one required parameter
     */
    public function testUserSetUserIdHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUserID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox User::setUsername() exists
     */
    public function testUserSetUsernameExists()
    {
        $class = new \ReflectionClass('\StoreCore\User');
        $this->assertTrue($class->hasMethod('setUsername'));
    }

    /**
     * @testdox User::setUsername() is public
     */
    public function testUserSetUsernameIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUsername');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox User::setUsername() has one required parameter
     */
    public function testUserSetUsernameHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\User', 'setUsername');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox User::setUsername() requires string
     */
    public function testUserSetUsernameRequiresString()
    {
        $user = new \StoreCore\User();
        $user->setUsername(42);
    }

    /**
     * @depends testUserSetUsernameRequiresString
     * @expectedException \InvalidArgumentException
     * @testdox User::setUsername() requires non-empty string
     */
    public function testUserSetUsernameRequiresNonEmptyString()
    {
        $user = new \StoreCore\User();
        $user->setUsername('');
    }

    /**
     * @testdox User::setUsername() sets username
     */
    public function testUserSetUsernameSetsUsername()
    {
        $user = new \StoreCore\User();
        $this->assertEmpty($user->getUsername());
        $user->setUsername('Alice Bob');
        $this->assertSame('Alice Bob', $user->getUsername());
    }
}
