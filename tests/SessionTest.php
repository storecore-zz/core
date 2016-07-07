<?php
class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreSessionClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Session.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Session');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Session::VERSION);
    }
}
