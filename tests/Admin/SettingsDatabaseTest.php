<?php
class SettingsDatabaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox SettingsDatabase class file exists
     */
    public function testSettingsDatabaseClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SettingsDatabase.php');
    }

    /**
     * @group distro
     * @testdox SettingsDatabase template file exists
     */
    public function testSettingsDatabaseTemplateFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SettingsDatabase.phtml');
    }

    /**
     * @group hmvc
     * @testdox SettingsDatabase is a controller
     */
    public function testSettingsDatabaseIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\SettingsDatabase::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }

    /**
     * @group hmvc
     * @testdox SettingsDatabase class is concrete
     */
    public function testSettingsDatabaseClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabase');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabase');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\SettingsDatabase::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\SettingsDatabase::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\SettingsDatabase::VERSION);
    }


    /**
     * @testdox SettingsDatabase::__construct() exists
     */
    public function testSettingsDatabaseConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabase');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testSettingsDatabaseConstructExists
     * @testdox SettingsDatabase::__construct() is public
     */
    public function testSettingsDatabaseConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SettingsDatabase', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testSettingsDatabaseConstructExists
     * @testdox SettingsDatabase::__construct() has one required parameter
     */
    public function testSettingsDatabaseConstructHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SettingsDatabase', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
