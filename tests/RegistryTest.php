<?php
/**
 * @group hmvc
 */
class RegistryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testRegistryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Registry.php');
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Registry::VERSION);
        $this->assertInternalType('string', \StoreCore\Registry::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\Registry::VERSION);
    }


    /**
     * @group distro
     * @testdox Implemented PSR-11 ContainerInterface exists
     */
    public function testImplementedPsr11ContainerInterfaceExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Container/ContainerInterface.php');
    }

    /**
     * @group hmvc
     * @testdox Registry implements PSR-11 ContainerInterface
     */
    public function testRegistryImplementsPsr11ContainerInterface()
    {
        $registry = \StoreCore\Registry::getInstance();
        $this->assertInstanceOf(\Psr\Container\ContainerInterface::class, $registry);
    }

    /**
     * @group hmvc
     * @testdox Registry singleton cannot be instantiated
     */
    public function testRegistrySingletonCannotBeInstantiated()
    {
        $reflection = new \ReflectionClass('\StoreCore\Registry');
        $this->assertFalse($reflection->isInstantiable());

        $constructor = $reflection->getConstructor();
        $this->assertFalse($constructor->isPublic());
        $this->assertFalse($constructor->isProtected());
    }

    /**
     * @group hmvc
     * @testdox Registry singleton cannot be cloned
     */
    public function testRegistrySingletonCannotBeCloned()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertFalse($class->isCloneable());
    }


    /**
     * @group distro
     * @testdox Registry consuming abstract controller class file exists
     */
    public function testRegistryConsumingAbstractControllerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractController.php');
    }

    /**
     * @group hmvc
     * @testdox AbstractController class is abstract
     */
    public function testAbstractControllerClassIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\AbstractController');
        $this->assertTrue($class->isAbstract());
    }

    /**
     * @group distro
     * @testdox Registry consuming abstract model class file exists
     */
    public function testRegistryConsumingAbstractModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractModel.php');
    }

    /**
     * @group hmvc
     * @testdox AbstractModel class is abstract
     */
    public function testAbstractModelClassIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\AbstractModel');
        $this->assertTrue($class->isAbstract());
    }


    /**
     * @testdox Registry::get() exists
     */
    public function testRegistryGetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasMethod('get'));
    }

    /**
     * @depends testRegistryGetExists
     * @testdox Registry::get() is public
     */
    public function testRegistryGetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'get');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRegistryGetExists
     * @testdox Registry::get() has one required parameter
     */
    public function testRegistryGetHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'get');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRegistryGetHasOneRequiredParameter
     * @expectedException \Psr\Container\NotFoundExceptionInterface
     * @testdox Registry::get() throws \Psr\Container\NotFoundExceptionInterface on missing object
     */
    public function testRegistryGetThrowsPsrContainerNotFoundExceptionInterfaceOnMissingObject()
    {
        $registry = \StoreCore\Registry::getInstance();
        $var = $registry->get('FooBar');
    }


    /**
     * @testdox Registry::getInstance() exists
     */
    public function testRegistryGetInstanceExists()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasMethod('getInstance'));
    }

    /**
     * @depends testRegistryGetInstanceExists
     * @testdox Registry::getInstance() is public
     */
    public function testRegistryGetInstanceIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'getInstance');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRegistryGetInstanceExists
     * @testdox Registry::getInstance() is static
     */
    public function testRegistryGetInstanceIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'getInstance');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @depends testRegistryGetInstanceExists
     * @testdox Registry::getInstance() has no parameters
     */
    public function testRegistryGetInstanceHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'getInstance');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testRegistryGetInstanceExists
     * @testdox Registry::getInstance() returns self
     */
    public function testRegistryGetInstanceReturnsSelf()
    {
        $registry = \StoreCore\Registry::getInstance();
        $this->assertSame($registry::getInstance(), $registry);
    }


    /**
     * @testdox Registry::has() exists
     */
    public function testRegistryHasExists()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasMethod('has'));
    }

    /**
     * @depends testRegistryHasExists
     * @testdox Registry::has() is public
     */
    public function testRegistryHasIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'has');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testRegistryHasExists
     * @testdox Registry::has() has one required parameter
     */
    public function testRegistryHasHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'has');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testRegistryHasExists
     * @testdox Registry::has() returns false if object does not exist
     */
    public function testRegistryHasReturnsFalseIfObjectDoesNotExist()
    {
        $registry = \StoreCore\Registry::getInstance();
        $this->assertFalse($registry->has('Foo'));
    }

    /**
     * @depends testRegistryHasExists
     * @testdox Registry::has() returns true if object exists
     */
    public function testRegistryHasReturnsTrueIfObjectExists()
    {
        $registry = \StoreCore\Registry::getInstance();
        $object = new \stdClass();
        $registry->set('Foo', $object);
        $this->assertTrue($registry->has('Foo'));
    }


    /**
     * @testdox Registry::set() exists
     */
    public function testRegistrySetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Registry');
        $this->assertTrue($class->hasMethod('set'));
    }

    /**
     * @depends testRegistrySetExists
     * @testdox Registry::set() has two required parameters
     */
    public function testRegistrySetHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Registry', 'set');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }
}
