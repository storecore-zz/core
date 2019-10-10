<?php
/**
 * @coversDefaultClass \StoreCore\Database\OrderMapper
 */
class OrderMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox OrderMapper class file exists
     */
    public function testOrderMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/OrderMapper.php');
    }

    /**
     * @group hmvc
     * @testdox OrderMapper class is concrete
     */
    public function testOrderMapperClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }

    /**
     * @group hmvc
     * @testdox OrderMapper extends abstract data access object (DAO)
     */
    public function testOrderMapperExtendsAbstractDataAccessObjectDao()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractDataAccessObject'));
    }

    /**
     * @group hmvc
     * @testdox OrderMapper implements CRUD interface
     */
    public function testOrderMapperImplementsCrudInterface()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\CRUDInterface'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\OrderMapper::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\OrderMapper::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Database\OrderMapper::VERSION);
    }

    /**
     * @group hmvc
     * @testdox TABLE_NAME constant is defined
     */
    public function testTableNameConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->hasConstant('TABLE_NAME'));
    }

    /**
     * @depends testTableNameConstantIsDefined
     * @group hmvc
     * @testdox TABLE_NAME constant is non-empty string
     */
    public function testTableNameConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\OrderMapper::TABLE_NAME);
        $this->assertInternalType('string', \StoreCore\Database\OrderMapper::TABLE_NAME);
    }

    /**
     * @depends testTableNameConstantIsNonEmptyString
     * @group hmvc
     * @testdox TABLE_NAME is 'sc_orders'
     */
    public function testTableNameIsScOrders()
    {
        $this->assertEquals('sc_orders', \StoreCore\Database\OrderMapper::TABLE_NAME);
    }

    /**
     * @group hmvc
     * @testdox PRIMARY_KEY constant is defined
     */
    public function testPrimaryKeyConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->hasConstant('PRIMARY_KEY'));
    }

    /**
     * @depends testPrimaryKeyConstantIsDefined
     * @group hmvc
     * @testdox PRIMARY_KEY constant is non-empty string
     */
    public function testPrimaryKeyConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\OrderMapper::PRIMARY_KEY);
        $this->assertInternalType('string', \StoreCore\Database\OrderMapper::PRIMARY_KEY);
    }

    /**
     * @depends testPrimaryKeyConstantIsNonEmptyString
     * @group hmvc
     * @testdox PRIMARY_KEY is 'order_id'
     */
    public function testPrimaryKeyIsOrderId()
    {
        $this->assertEquals('order_id', \StoreCore\Database\OrderMapper::PRIMARY_KEY);
    }


    /**
     * @testdox OrderMapper::exists() exists
     */
    public function testOrderMapperExistsExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->hasMethod('exists'));
    }

    /**
     * @depends testOrderMapperExistsExists
     * @testdox OrderMapper::exists() is public
     */
    public function testOrderMapperExistsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderMapper', 'exists');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderMapperExistsExists
     * @testdox OrderMapper::exists() has one required parameter
     */
    public function testOrderMapperExistsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderMapper', 'exists');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox OrderMapper::getOrder() exists
     */
    public function testOrderMapperGetOrderExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\OrderMapper');
        $this->assertTrue($class->hasMethod('getOrder'));
    }

    /**
     * @depends testOrderMapperGetOrderExists
     * @testdox OrderMapper::getOrder() is public
     */
    public function testOrderMapperGetOrderIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderMapper', 'getOrder');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testOrderMapperGetOrderExists
     * @testdox OrderMapper::getOrder() has one required parameter
     */
    public function testOrderMapperGetOrderHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\OrderMapper', 'getOrder');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
