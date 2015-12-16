<?php
class DatabaseBackupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testDatabaseBackupClassFileExists()
    {
        $this->assertFileExists(\StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'Database/Backup.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Backup');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0-alpha.1', \StoreCore\Database\Backup::VERSION);
    }

    public function testSaveMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Backup', 'save');
        $this->assertTrue($method->isPublic());
    }

    public function testSaveMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Backup', 'save');
        $this->assertTrue($method->isStatic());
    }
}
