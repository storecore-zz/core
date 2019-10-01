<?php
class SignInTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox SignIn class file exists
     */
    public function testSignInClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SignIn.php');
    }

    /**
     * @group distro
     * @testdox SignIn template file exists
     */
    public function testSignInTemplateFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/SignIn.phtml');
    }

    /**
     * @group hmvc
     * @testdox SignIn is a controller
     */
    public function testSignInIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\Admin\SignIn::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }

    /**
     * @group hmvc
     * @testdox SignIn class is concrete
     */
    public function testSignInClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SignIn');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SignIn');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Admin\SignIn::VERSION);
        $this->assertInternalType('string', \StoreCore\Admin\SignIn::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Admin\SignIn::VERSION);
    }


    /**
     * @testdox SignIn::__construct() exists
     */
    public function testSignInConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\SignIn');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testSignInConstructExists
     * @testdox SignIn::__construct() is public
     */
    public function testSignInConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SignIn', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testSignInConstructExists
     * @testdox SignIn::__construct() has one required parameter
     */
    public function testSignInConstructHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\SignIn', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
