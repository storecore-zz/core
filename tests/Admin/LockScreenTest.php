<?php
class LockScreenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testLockScreenClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/LockScreen.php');
    }

    /**
     * @group hmvc
     */
    public function testLockScreenClassExtendsAbstractController()
    {
        ob_start();
        $object = new \StoreCore\Admin\LockScreen(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf(\StoreCore\AbstractController::class, $object);
        ob_end_clean();
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\LockScreen');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\LockScreen::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\LockScreen::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\LockScreen::VERSION);
    }
}
