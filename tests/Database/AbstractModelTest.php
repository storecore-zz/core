<?php
class AbstractModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testAbstractModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/AbstractModel.php');
    }

    /**
     * @group hmvc
     */
    public function testAbstractModelIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractModel');
        $this->assertTrue($class->isAbstract());
    }

    /**
     * @group hmvc
     */
    public function testDatabaseAbstractModelExtendsCoreAbstractModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractModel');
        $this->assertTrue($class->isSubclassOf('\StoreCore\AbstractModel'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractModel');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\AbstractModel::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\AbstractModel::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\Database\AbstractModel::VERSION);
    }
}
