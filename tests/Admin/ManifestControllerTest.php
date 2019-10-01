<?php
class ManifestControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ManifestController class file exists
     */
    public function testManifestControllerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/ManifestController.php');
    }

    /**
     * @group hmvc
     * @testdox ManifestController is a controller
     */
    public function testManifestControllerIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\ManifestController::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }

    /**
     * @group hmvc
     * @testdox ManifestController class is concrete
     */
    public function testManifestControllerClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\ManifestController');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\ManifestController');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\ManifestController::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\ManifestController::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\ManifestController::VERSION);
    }
}
