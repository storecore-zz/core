<?php
/**
 * @group hmvc
 */
class RegistryTest extends PHPUnit_Framework_TestCase
{
    public function testCoreRegistryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Registry.php');
    }

    public function testVersionConstantIsDefined()
    {
        $this->assertTrue(defined('\StoreCore\Registry::VERSION'));
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

    public function testRegistryConsumingAbstractControllerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'AbstractController.php');
    }

    public function testRegistryConsumingAbstractModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'AbstractModel.php');
    }
}
