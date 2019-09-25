<?php
class CookieContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox CookieContainer class file exists
     */
    public function testCookieContainerClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'CookieContainer.php');
    }

    /**
     * @group hmvc
     * @testdox CookieContainer class is concrete
     */
    public function testCookieContainerClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\CookieContainer');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Implemented ContainerInterface interface file exists
     */
    public function testImplementedContainerInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr/Container/ContainerInterface.php');
    }

    /**
     * @depends testImplementedContainerInterfaceInterfaceFileExists
     * @group hmvc
     * @testdox CookieContainer implements PSR-11 ContainerInterface
     */
    public function testCookieContainerImplementsPsr11ContainerInterface()
    {
        $class = new \StoreCore\CookieContainer();
        $this->assertInstanceOf(\Psr\Container\ContainerInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\CookieContainer');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\CookieContainer::VERSION);
        $this->assertInternalType('string', \StoreCore\CookieContainer::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\CookieContainer::VERSION);
    }


    /**
     * @testdox CookieContainer::__construct() exists
     */
    public function testCookieContainerConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\CookieContainer');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testCookieContainerConstructExists
     * @testdox CookieContainer::__construct() is public
     */
    public function testCookieContainerConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCookieContainerConstructExists
     * @testdox CookieContainer::__construct() has one optional parameter
     */
    public function testCookieContainerConstructHasOneOptionalParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox CookieContainer::get() exists
     */
    public function testCookieContainerGetExists()
    {
        $class = new \ReflectionClass('\StoreCore\CookieContainer');
        $this->assertTrue($class->hasMethod('get'));
    }

    /**
     * @depends testCookieContainerGetExists
     * @testdox CookieContainer::get() is public
     */
    public function testCookieContainerGetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', 'get');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCookieContainerGetExists
     * @testdox CookieContainer::get() has one required parameter
     */
    public function testCookieContainerGetHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', 'get');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testCookieContainerGetHasOneRequiredParameter
     * @expectedException Psr\Container\NotFoundException
     * @testdox CookieContainer::get() throws Psr\Container\NotFoundException when cookie does not exist
     */
    public function testCookieContainerGetThrowsPsrContainerNotFoundExceptionWhenCookieDoesNotExist()
    {
        $container = new \StoreCore\CookieContainer();
        $value = $container->get('KeyThatDoesNotExist');
    }

    /**
     * @depends testCookieContainerGetExists
     * @depends testCookieContainerGetHasOneRequiredParameter
     * @testdox CookieContainer::get() returns Base64 decoded cookie value
     */
    public function testCookieContainerGetReturnsBase64DecodedCookieValue()
    {
        $cookie_params = array('Language' => base64_encode('nl-NL'));
        $container = new \StoreCore\CookieContainer($cookie_params);
        $this->assertSame('nl-NL', $container->get('Language'));
    }


    /**
     * @testdox CookieContainer::has() exists
     */
    public function testCookieContainerHasExists()
    {
        $class = new \ReflectionClass('\StoreCore\CookieContainer');
        $this->assertTrue($class->hasMethod('has'));
    }

    /**
     * @depends testCookieContainerHasExists
     * @testdox CookieContainer::has() is public
     */
    public function testCookieContainerHasIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', 'has');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCookieContainerHasExists
     * @testdox CookieContainer::has() has one required parameter
     */
    public function testCookieContainerHasHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\CookieContainer', 'has');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testCookieContainerHasExists
     * @depends testCookieContainerHasHasOneRequiredParameter
     * @testdox CookieContainer::has() returns boolean
     */
    public function testCookieContainerHasReturnsBoolean()
    {
        $container = new \StoreCore\CookieContainer();
        $this->assertInternalType('bool', $container->has('Foo'));
        $this->assertFalse($container->has('Foo'));

        $container = new \StoreCore\CookieContainer( array('Foo' => 'Bar'));
        $this->assertInternalType('bool', $container->has('Foo'));
        $this->assertTrue($container->has('Foo'));
    }

    /**
     * @depends testCookieContainerHasReturnsBoolean
     * @testdox CookieContainer::has() returns false by default
     */
    public function testCookieContainerHasReturnsFalseByDefault()
    {
        $container = new \StoreCore\CookieContainer();
        $this->assertFalse($container->has('NoFooNoGlory'));
    }
}
