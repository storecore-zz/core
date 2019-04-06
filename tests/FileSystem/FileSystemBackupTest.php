<?php
class FileSystemBackupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testFileSystemBackupClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/Backup.php');
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Backup');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\Backup::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\Backup::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\Backup::VERSION);
    }


    public function testSaveMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Backup', 'save');
        $this->assertTrue($method->isPublic());
    }

    public function testSaveMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Backup', 'save');
        $this->assertTrue($method->isStatic());
    }
}
