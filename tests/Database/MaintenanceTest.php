<?php
class MaintenanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testDatabaseMaintenanceClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Maintenance.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Maintenance::VERSION);
    }

    public function testRestoreMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'restore');
        $this->assertTrue($method->isPublic());
    }

    public function testUpdateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'update');
        $this->assertTrue($method->isPublic());
    }
}
