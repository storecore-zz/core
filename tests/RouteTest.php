<?php
/**
 * @group hmvc
 */
class RouteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreRouteClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Route.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Route');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Route::VERSION);
    }
}
