<?php
class LocationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Location model class file exists
     */
    public function testLocationModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Location.php');
    }

    /**
     * @group hmvc
     * @testdox Location model extends \StoreCore\AbstractModel
     */
    public function testLocationModelExtendsStoreCoreAbstractModel()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\AbstractModel', $location);
    }

    /**
     * @group hmvc
     * @testdox Location model implements \StoreCore\Types\StringableInterface
     */
    public function testLocationModelImplementsStoreCoreTypesStringableInterface()
    {
        $location = new \StoreCore\Location(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\Types\StringableInterface', $location);
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Location::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Location::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Store::VERSION);
    }
}
