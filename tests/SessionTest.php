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


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Session');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Session::VERSION);
        $this->assertInternalType('string', \StoreCore\Session::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Session::VERSION);
    }
}
