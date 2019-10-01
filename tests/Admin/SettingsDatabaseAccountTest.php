<?php
class SettingsDatabaseAccountTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox SettingsDatabaseAccount class file exists
     */
    public function testSettingsDatabaseAccountClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SettingsDatabaseAccount.php');
    }

    /**
     * @group distro
     * @testdox SettingsDatabaseAccount template file exists
     */
    public function testSettingsDatabaseAccountTemplateFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SettingsDatabaseAccount.phtml');
    }

    /**
     * @group hmvc
     * @testdox SettingsDatabaseAccount is a controller
     */
    public function testSettingsDatabaseAccountIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\SettingsDatabaseAccount::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }

    /**
     * @group hmvc
     * @testdox SettingsDatabaseAccount class is concrete
     */
    public function testSettingsDatabaseAccountClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabaseAccount');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabaseAccount');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\SettingsDatabaseAccount::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\SettingsDatabaseAccount::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\SettingsDatabaseAccount::VERSION);
    }


    /**
     * @testdox SettingsDatabaseAccount::__construct() exists
     */
    public function testSettingsDatabaseAccountConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SettingsDatabaseAccount');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testSettingsDatabaseAccountConstructExists
     * @testdox SettingsDatabaseAccount::__construct() is public
     */
    public function testSettingsDatabaseAccountConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SettingsDatabaseAccount', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testSettingsDatabaseAccountConstructExists
     * @testdox SettingsDatabaseAccount::__construct() has one required parameter
     */
    public function testSettingsDatabaseAccountConstructHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SettingsDatabaseAccount', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
