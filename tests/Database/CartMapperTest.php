<?php
class CartMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCartMapperClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database' . DIRECTORY_SEPARATOR .  'CartMapper.php');
    }

    /**
     * @group hmvc
     */
    public function testCartMapperIsAnAbstractModel()
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
     * @testdox Public getOrder() method exists
     */
    public function testPublicGetOrderMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\CartMapper');
        $this->assertTrue($class->hasMethod('getOrder'));
    }
}
