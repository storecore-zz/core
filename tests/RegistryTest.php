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

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Registry::VERSION);
        $this->assertInternalType('string', \StoreCore\Registry::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
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
