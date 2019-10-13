<?php
/**
 * @coversDefaultClass \StoreCore\Database\Robots
 * @group seo
 */
class RobotsModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Robots class file exists
     */
    public function testRobotsClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/Robots.php');
    }

    /**
     * @group hmvc
     * @testdox Robots class is concrete
     */
    public function testRobotsClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Robots');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox Robots is a database model
     */
    public function testRobotsIsADatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Robots');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Robots');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\Robots::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\Robots::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.0.2', \StoreCore\Database\Robots::VERSION);
    }


    /**
     * @testdox Robots::getAllDisallows() exists
     */
    public function testRobotsGetAllDisallowsExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\Robots');
        $this->assertTrue($class->hasMethod('getAllDisallows'));
    }

    /**
     * @depends testRobotsGetAllDisallowsExists
     * @testdox Robots::getAllDisallows() is public
     */
    public function testRobotsGetAllDisallowsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Robots', 'getAllDisallows');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRobotsGetAllDisallowsExists
     * @testdox Robots::getAllDisallows() has no parameters
     */
    public function testRobotsGetAllDisallowsHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\Robots', 'getAllDisallows');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }
}
