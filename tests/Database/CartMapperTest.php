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
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\CartMapper');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     */
    public function testVersionMatchesDevelopmentBranch()
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
