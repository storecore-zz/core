<?php
class ConfiguratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testConfiguratorClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Admin/Configurator.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Configurator');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\Admin\Configurator::VERSION);
    }

    /**
     * @testdox set() method exists
     */
    public function testSetMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Configurator');
        $this->assertTrue($class->hasMethod('set'));
    }

    /**
     * @testdox set() method is public
     */
    public function testSetMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Configurator', 'set');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox write() method exists
     */
    public function testWriteMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Admin\Configurator');
        $this->assertTrue($class->hasMethod('write'));
    }

    /**
     * @testdox write() method is public
     */
    public function testWriteMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Configurator', 'write');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox write() method is static
     */
    public function testWriteMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Admin\Configurator', 'write');
        $this->assertTrue($method->isStatic());
    }
}
