<?php
class ManifestModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testManifestModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/ManifestModel.php');
    }

    /**
     * @group hmvc
     */
    public function testManifestModelClassExtendsAbstractModel()
    {
        $object = new \StoreCore\Admin\ManifestModel(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\StoreCore\AbstractModel::class, $object);
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\ManifestModel');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Admin\ManifestModel::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Admin\ManifestModel::VERSION);
    }
}
