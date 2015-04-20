<?php
/**
 * @group hmvc
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testCoreResponseClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Response.php');
    }

    public function testVersionConstantIsDefined()
    {
        $this->assertTrue(defined('\StoreCore\Response::VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Response::VERSION);
    }
}
