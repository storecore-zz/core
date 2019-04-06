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
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Database\UserMapper::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Database\UserMapper::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\UserMapper::VERSION);
    }

    /**
     * @group hmvc
     */
    public function testTableNameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('TABLE_NAME'));
    }

    /**
     * @depends testTableNameConstantIsDefined
     * @group hmvc
     */
    public function testTableNameConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $class_constant = $class->getConstant('TABLE_NAME');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @group hmvc
     */
    public function testPrimaryKeyConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('PRIMARY_KEY'));
    }

    /**
     * @depends testPrimaryKeyConstantIsDefined
     * @group hmvc
     */
    public function testPrimaryKeyConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $class_constant = $class->getConstant('PRIMARY_KEY');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
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
