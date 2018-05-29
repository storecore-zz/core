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
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $class_constant = $class->getConstant('VERSION');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @group hmvc
     */
    public function testTableNameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('TABLE_NAME'));
    }

    /**
     * @depends testTableNameConstantIsDefined
     * @group hmvc
     */
    public function testTableNameConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $class_constant = $class->getConstant('TABLE_NAME');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @group hmvc
     */
    public function testPrimaryKeyConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasConstant('PRIMARY_KEY'));
    }

    /**
     * @depends testPrimaryKeyConstantIsDefined
     * @group hmvc
     */
    public function testPrimaryKeyConstantIsNonEmptyString()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $class_constant = $class->getConstant('PRIMARY_KEY');
        $this->assertNotEmpty($class_constant);
        $this->assertTrue(is_string($class_constant));
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::find
     * @testdox Public find() method exists
     */
    public function testPublicFindMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('find'));
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::find
     * @depends testPublicFindMethodExists
     * @testdox Public find() method is public
     */
    public function testPublicFindMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'find');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::getStore
     * @testdox Public getStore() method exists
     */
    public function testPublicGetStoreMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('getStore'));
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::find
     * @depends testPublicGetStoreMethodExists
     * @testdox Public getStore() method is public
     */
    public function testPublicGetStoreMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'getStore');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::save
     * @testdox Public save() method exists
     */
    public function testPublicSaveMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\StoreMapper');
        $this->assertTrue($class->hasMethod('save'));
    }

    /**
     * @covers \StoreCore\Database\StoreMapper::save
     * @depends testPublicSaveMethodExists
     * @testdox Public save() method is public
     */
    public function testPublicSaveMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\StoreMapper', 'save');
        $this->assertTrue($method->isPublic());
    }
}