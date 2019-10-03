<?php
/**
 * @coversDefaultClass \StoreCore\Admin\AccessControlWhitelist
 * @group security
 */
class AccessControlWhitelistTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AccessControlWhitelist class file exists
     */
    public function testAccessControlWhitelistClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/AccessControlWhitelist.php');
    }

    /**
     * @group hmvc
     * @testdox AccessControlWhitelist class is concrete
     */
    public function testAccessControlWhitelistClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\AccessControlWhitelist');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox AccessControlWhitelist is a controller
     */
    public function testAccessControlWhitelistIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\AccessControlWhitelist::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\AccessControlWhitelist');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\AccessControlWhitelist::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\AccessControlWhitelist::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\AccessControlWhitelist::VERSION);
    }


    /**
     * @testdox AccessControlWhitelist::check() exists
     */
    public function testAccessControlWhitelistCheckExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\AccessControlWhitelist');
        $this->assertTrue($class->hasMethod('check'));
    }

    /**
     * @depends testAccessControlWhitelistCheckExists
     * @testdox AccessControlWhitelist::check() is public
     */
    public function testAccessControlWhitelistCheckIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\AccessControlWhitelist', 'check');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testAccessControlWhitelistCheckExists
     * @testdox AccessControlWhitelist::check() has no parameters
     */
    public function testAccessControlWhitelistCheckHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\AccessControlWhitelist', 'check');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
