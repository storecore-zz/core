<?php
class CartMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox CartMapper class file exists
     */
    public function testCartMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR .  'CartMapper.php');
    }

    /**
     * @group hmvc
     * @testdox CartMapper is a database model
     */
    public function testCartMapperIsADatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\CartMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\CartMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\CartMapper::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\CartMapper::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\CartMapper::VERSION);
    }


    /**
     * @testdox CartMapper::getOrder() exists
     */
    public function testCartMapperGetOrderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\CartMapper');
        $this->assertTrue($class->hasMethod('getOrder'));
    }

    /**
     * @depends testCartMapperGetOrderExists
     * @testdox CartMapper::getOrder() is public
     */
    public function testCartMapperGetOrderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\CartMapper', 'getOrder');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCartMapperGetOrderExists
     * @testdox CartMapper::getOrder() has one required parameter
     */
    public function testCartMapperGetOrderHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\CartMapper', 'getOrder');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
