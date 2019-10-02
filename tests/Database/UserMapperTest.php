<?php
/**
 * @group security
 */
class UserMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testUserMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'UserMapper.php');
    }

    /**
     * @group distro
     */
    public function testExtendedAbstractDataAccessObjectClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'AbstractDataAccessObject.php');
    }

    /**
     * @group hmvc
     */
    public function testUserMapperIsAnAbstractDataAccessObject()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractDataAccessObject'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\UserMapper::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\UserMapper::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\UserMapper::VERSION);
    }


    /**
     * @group hmvc
     * @testdox TABLE_NAME constant is defined
     */
    public function testTableNameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('TABLE_NAME'));
    }

    /**
     * @depends testTableNameConstantIsDefined
     * @group hmvc
     * @testdox TABLE_NAME constant is non-empty string
     */
    public function testTableNameConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\UserMapper::TABLE_NAME);
        $this->assertInternalType('string', \StoreCore\Database\UserMapper::TABLE_NAME);
    }

    /**
     * @group hmvc
     * @testdox PRIMARY_KEY constant is defined
     */
    public function testPrimaryKeyConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('PRIMARY_KEY'));
    }

    /**
     * @depends testPrimaryKeyConstantIsDefined
     * @group hmvc
     * @testdox PRIMARY_KEY constant is non-empty string
     */
    public function testPrimaryKeyConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\UserMapper::PRIMARY_KEY);
        $this->assertInternalType('string', \StoreCore\Database\UserMapper::PRIMARY_KEY);
    }


    /**
     * @testdox Public ban() method exists
     */
    public function testPublicAuthenticateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('ban'));
    }

    /**
     * @testdox Public ban() method is public
     */
    public function testPublicBanMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'ban');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUser() method is public
     */
    public function testPublicGetUserMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUser');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUser() method exists
     */
    public function testPublicGetUserMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUser'));
    }

    /**
     * @testdox Public getUserByEmailAddress() method exists
     */
    public function testPublicGetUserByEmailAddressMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUserByEmailAddress'));
    }

    /**
     * @testdox Public getUserByEmailAddress() method is public
     */
    public function testPublicGetUserByEmailAddressMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByEmailAddress');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getUserByUsername() method exists
     */
    public function testPublicGetUserByUsernameMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUserByUsername'));
    }

    /**
     * @testdox Public getUserByUsername() method is public
     */
    public function testPublicGetUserByUsernameMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByUsername');
        $this->assertTrue($method->isPublic());
    }
}
