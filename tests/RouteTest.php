<?php
/**
 * @group hmvc
 */
class RouteTest extends PHPUnit_Framework_TestCase
{
    public function testCoreRouteClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Route.php');
    }

    public function testVersionConstantIsDefined()
    {
        $this->assertTrue(defined('\StoreCore\Route::VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Route::VERSION);
    }
}
