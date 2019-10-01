<?php
class InstallerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Installer class file exists
     */
    public function testInstallerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/Installer.php');
    }

    /**
     * @group hmvc
     * @testdox Installer is a controller
     */
    public function testInstallerIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\Installer::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }

    /**
     * @group hmvc
     * @testdox Installer class is concrete
     */
    public function testInstallerClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Installer');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Installer');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\Installer::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\Installer::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\Installer::VERSION);
    }


    /**
     * @testdox Installer::__construct() exists
     */
    public function testInstallerConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Installer');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testInstallerConstructExists
     * @testdox Installer::__construct() is public
     */
    public function testInstallerConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Installer', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testInstallerConstructExists
     * @testdox Installer::__construct() has one required parameter
     */
    public function testInstallerConstructHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Installer', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Installer::__destruct() exists
     */
    public function testInstallerDestructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Installer');
        $this->assertTrue($class->hasMethod('__destruct'));
    }

    /**
     * @depends testInstallerDestructExists
     * @testdox Installer::__destruct() is public
     */
    public function testInstallerDestructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Installer', '__destruct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testInstallerDestructExists
     * @testdox Installer::__destruct() has no parameters
     */
    public function testInstallerDestructHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Installer', '__destruct');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
