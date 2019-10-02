<?php
class StoreMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testStoreMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'StoreMapper.php');
    }

    /**
     * @group distro
     */
    public function testExtendedAbstractDataAccessObjectClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR . 'AbstractDataAccessObject.php');
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\StoreMapper::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\StoreMapper::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\StoreMapper::VERSION);
    }


    /**
     * @group hmvc
     * @testdox TABLE_NAME constant is defined
     */
    public function testTableNameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('TABLE_NAME'));
    }

    /**
     * @depends testTableNameConstantIsDefined
     * @group hmvc
     * @testdox TABLE_NAME constant is non-empty string
     */
    public function testTableNameConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\StoreMapper::TABLE_NAME);
        $this->assertInternalType('string', \StoreCore\Database\StoreMapper::TABLE_NAME);
    }

    /**
     * @group hmvc
     * @testdox PRIMARY_KEY constant is defined
     */
    public function testPrimaryKeyConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('PRIMARY_KEY'));
    }

    /**
     * @depends testPrimaryKeyConstantIsDefined
     * @group hmvc
     * @testdox PRIMARY_KEY constant is non-empty string
     */
    public function testPrimaryKeyConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\StoreMapper::PRIMARY_KEY);
        $this->assertInternalType('string', \StoreCore\Database\StoreMapper::PRIMARY_KEY);
    }


    /**
     * @testdox Public find() method exists
     */
    public function testPublicFindMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('find'));
    }

    /**
     * @depends testPublicFindMethodExists
     * @testdox Public find() method is public
     */
    public function testPublicFindMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'find');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getStore() method exists
     */
    public function testPublicGetStoreMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('getStore'));
    }

    /**
     * @depends testPublicGetStoreMethodExists
     * @testdox Public getStore() method is public
     */
    public function testPublicGetStoreMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'getStore');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public save() method exists
     */
    public function testPublicSaveMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('save'));
    }

    /**
     * @depends testPublicSaveMethodExists
     * @testdox Public save() method is public
     */
    public function testPublicSaveMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'save');
        $this->assertTrue($method->isPublic());
    }
}
