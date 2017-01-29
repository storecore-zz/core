<?php
/**
 * @group hmvc
 */
class RegistryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreRegistryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Registry.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Registry::VERSION);
    }

    public function testRegistrySingletonCannotBeInstantiated()
    {
        $reflection = new \ReflectionClass('\StoreCore\Registry');
        $constructor = $reflection->getConstructor();
        $this->assertFalse($constructor->isPublic());
    }

    public function testRegistrySingletonCannotBeCloned()
    {
        $reflection = new \ReflectionClass('\StoreCore\Registry');
        $this->assertFalse($reflection->isCloneable());
    }

    /**
     * @group distro
     */
    public function testRegistryConsumingAbstractControllerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractController.php');
    }

    /**
     * @group distro
     */
    public function testRegistryConsumingAbstractModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractModel.php');
    }
}
