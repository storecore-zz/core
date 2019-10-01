<?php
/**
 * @group seo
 */
class RobotsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Robots class file exists
     */
    public function testRobotsClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'FileSystem/Robots.php');
    }

    /**
     * @group hmvc
     * @testdox Robots class is concrete
     */
    public function testRobotsClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Robots');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox Robots is a controller
     */
    public function testRobotsIsAController()
    {
        $class = new \ReflectionClass(\StoreCore\FileSystem\Robots::class);
        $this->assertTrue($class->isSubclassOf(\StoreCore\AbstractController::class));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Robots');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\FileSystem\Robots::VERSION);
        $this->assertInternalType('string', \StoreCore\FileSystem\Robots::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FileSystem\Robots::VERSION);
    }


    /**
     * @testdox Robots::__construct() exists
     */
    public function testRobotsConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\FileSystem\Robots');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testRobotsConstructExists
     * @testdox Robots::__construct() is public
     */
    public function testRobotsConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Robots', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRobotsConstructExists
     * @testdox Robots::__construct() has one required parameter
     */
    public function testRobotsConstructorHasOneRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\FileSystem\Robots', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
