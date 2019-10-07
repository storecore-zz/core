<?php
/**
 * @coversDefaultClass \StoreCore\Database\UserMapper
 * @group security
 */
class UserMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox UserMapper class file exists
     */
    public function testUserMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'UserMapper.php');
    }

    /**
     * @group distro
     * @testdox Extended AbstractDataAccessObject class file exists
     */
    public function testExtendedAbstractDataAccessObjectClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'AbstractDataAccessObject.php');
    }

    /**
     * @group hmvc
     * @testdox UserMapper is an abstract data access object (DAO)
     */
    public function testUserMapperIsAnAbstractDataAccessObjectDao()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractDataAccessObject'));
    }

    /**
     * @group hmvc
     * @testdox UserMapper implements CRUD interface
     */
    public function testUserMapperImplementsCrudInterface()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\CRUDInterface'));
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
     * @depends testTableNameConstantIsNonEmptyString
     * @group hmvc
     * @testdox TABLE_NAME is 'sc_users'
     */
    public function testTableNameIsScUsers()
    {
        $this->assertEquals('sc_users', \StoreCore\Database\UserMapper::TABLE_NAME);
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
     * @depends testPrimaryKeyConstantIsNonEmptyString
     * @group hmvc
     * @testdox PRIMARY_KEY is 'user_id'
     */
    public function testPrimaryKeyIsUserId()
    {
        $this->assertEquals('user_id', \StoreCore\Database\UserMapper::PRIMARY_KEY);
    }


    /**
     * @testdox UserMapper::ban() exists
     */
    public function testUserMapperBanExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('ban'));
    }

    /**
     * @testdox UserMapper::ban() is public
     */
    public function testUserMapperBanIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'ban');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox UserMapper::ban() has one required parameter
     */
    public function testUserMapperBanHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'ban');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox UserMapper::getUser() exists
     */
    public function testUserMapperGetUserExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUser'));
    }

    /**
     * @testdox UserMapper::getUser() is public
     */
    public function testUserMapperGetUserIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUser');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox UserMapper::getUser() has one required parameter
     */
    public function testUserMapperGetUserHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUser');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox UserMapper::getUserByEmailAddress() exists
     */
    public function testUserMapperGetUserByEmailAddressExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUserByEmailAddress'));
    }

    /**
     * @testdox UserMapper::getUserByEmailAddress() is public
     */
    public function testUserMapperGetUserByEmailAddressIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByEmailAddress');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox UserMapper::getUserByEmailAddress() has one required parameter
     */
    public function testUserMapperGetUserByEmailAddressHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByEmailAddress');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox UserMapper::getUserByUsername() exists
     */
    public function testUserMapperGetUserByUsernameExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('getUserByUsername'));
    }

    /**
     * @testdox UserMapper::getUserByUsername() is public
     */
    public function testUserMapperGetUserByUsernameIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByUsername');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox UserMapper::getUserByUsername() has one required parameter
     */
    public function testUserMapperGetUserByUsernameHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'getUserByUsername');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox UserMapper::save() exists
     */
    public function testUserMapperSaveExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\UserMapper');
        $this->assertTrue($class->hasMethod('save'));
    }

    /**
     * @testdox UserMapper::save() is public
     */
    public function testUserMapperSaveIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'save');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox UserMapper::save() has one required parameter
     */
    public function testUserMapperSaveHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\UserMapper', 'save');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
