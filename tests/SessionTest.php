<?php
class SessionTest extends PHPUnit_Framework_TestCase
{
    public function testCoreSessionClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Session.php');
    }

    public function testVersionConstantIsDefined()
    {
        $this->assertTrue(defined('\StoreCore\Session::VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Session::VERSION);
    }
}
