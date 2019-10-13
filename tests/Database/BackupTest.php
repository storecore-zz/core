<?php
class BackupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Backup class file exists
     */
    public function testBackupClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR .  'Backup.php');
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Backup');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Backup::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Backup::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\Backup::VERSION);
    }


    /**
     * @testdox Backup::save() exists
     */
    public function testBackupSaveExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Backup');
        $this->assertTrue($class->hasMethod('save'));
    }

    /**
     * @testdox Backup::save() is public
     */
    public function testBackupSaveIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Backup', 'save');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Backup::save() is static
     */
    public function testBackupSaveIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Backup', 'save');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox Backup::save() has two optional parameters
     */
    public function testBackupSaveHasTwoOptionalParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Backup', 'save');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
