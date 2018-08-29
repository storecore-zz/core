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
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\LockScreen');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Admin\LockScreen::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Admin\LockScreen::VERSION);
    }
}
