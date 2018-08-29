<?php
class ManifestControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testManifestControllerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/ManifestController.php');
    }

    /**
     * @group hmvc
     */
    public function testManifestControllerClassExtendsAbstractController()
    {
        ob_start();
        $object = new \StoreCore\Admin\ManifestController(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\StoreCore\AbstractController::class, $object);
        ob_end_clean();
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\ManifestController');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Admin\ManifestController::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Admin\ManifestController::VERSION);
    }
}
