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
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
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
