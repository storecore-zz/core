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

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches development dranch
     */
    public function testVersionConstantMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Maintenance::VERSION);
    }

    /**
     * @testdox Public __construct() method exists
     */
    public function testPublicConstructMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testPublicConstructMethodExists
     * @testdox Public __construct() method is public
     */
    public function testPublicConstructMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public emptyRecycleBin() method exists
     */
    public function testPublicEmptyRecycleBinMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('emptyRecycleBin'));
    }

    /**
     * @depends testPublicEmptyRecycleBinMethodExists
     * @testdox Public emptyRecycleBin() method is public
     */
    public function testPublicEmptyRecycleBinMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'emptyRecycleBin');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getBackupFiles() method exists
     */
    public function testPublicGetBackupFilesMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('getBackupFiles'));
    }

    /**
     * @depends testPublicGetBackupFilesMethodExists
     * @testdox Public getBackupFiles() method is public
     */
    public function testPublicGetBackupFilesMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'getBackupFiles');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getTables() method exists
     */
    public function testPublicGetTablesMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('getTables'));
    }

    /**
     * @depends testPublicGetTablesMethodExists
     * @testdox Public getTables() method is public
     */
    public function testPublicGetTablesMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'getTables');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public restore() method exists
     */
    public function testPublicRestoreMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('restore'));
    }

    /**
     * @depends testPublicRestoreMethodExists
     * @testdox Public restore() method is public
     */
    public function testPublicRestoreMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'restore');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public update() method exists
     */
    public function testPublicUpdateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Maintenance');
        $this->assertTrue($class->hasMethod('update'));
    }

    /**
     * @depends testPublicUpdateMethodExists
     * @testdox Public update() method is public
     */
    public function testUpdateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Maintenance', 'update');
        $this->assertTrue($method->isPublic());
    }
}
