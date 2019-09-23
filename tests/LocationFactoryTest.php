<?php
class LocationFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox LocationFactory class file exists
     */
    public function testLocationFactoryClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'LocationFactory.php');
    }

    /**
     * @group hmvc
     * @testdox LocationFactory class is concrete
     */
    public function testLocationFactoryClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\LocationFactory');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Implemented UriFactoryInterface interface file exists
     */
    public function testImplementedUriFactoryInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UriFactoryInterface.php');
    }

    /**
     * @depends testLocationFactoryClassIsConcrete
     * @group hmvc
     * @testdox LocationFactory implements PSR-17 UriFactoryInterface
     */
    public function testLocationFactoryImplementsPsr17UriFactoryInterface()
    {
        $class = new \StoreCore\LocationFactory();
        $this->assertInstanceOf(\Psr\Http\Message\UriFactoryInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\LocationFactory');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\LocationFactory::VERSION);
        $this->assertInternalType('string', \StoreCore\LocationFactory::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\LocationFactory::VERSION);
    }


    /**
     * @testdox LocationFactory::createUri() exists
     */
    public function testLocationFactoryCreateUriExists()
    {
        $class = new \ReflectionClass('\StoreCore\LocationFactory');
        $this->assertTrue($class->hasMethod('createUri'));
    }

    /**
     * @depends testLocationFactoryCreateUriExists
     * @testdox LocationFactory::createUri() is public
     */
    public function testLocationFactoryCreateUriIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\LocationFactory', 'createUri');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationFactoryCreateUriExists
     * @testdox LocationFactory::createUri() has one parameter
     */
    public function testLocationFactoryCreateUriHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\LocationFactory', 'createUri');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @group hmvc
     * @testdox LocationFactory::createUri() returns instance of PSR-7 UriInterface
     */
    public function testLocationFactoryCreateUriReturnsInstanceOfPsr7UriInterface()
    {
        $common_uris = array(
            'https://www.example.com',
            'https://www.example.com/',
            'https://www.example.com/foo',
            'https://www.example.com/foo/',
            'https://www.example.com/foo/bar',
            'https://www.example.com/foo/bar.html',
        );

        foreach ($common_uris as $uri) {
            $factory = new \StoreCore\LocationFactory();
            $location = $factory->createUri($uri);
            $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $location);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox LocationFactory::createUri() throws invalid argument exception if URI cannot be parsed
     */
    public function testLocationFactoryCreateUriThrowsInvalidArgumentExceptionIfUriCannotBeParsed()
    {
        $factory = new \StoreCore\LocationFactory();
        $location = $factory->createUri('');
    }


    /**
     * @testdox LocationFactory::getCurrentLocation() exists
     */
    public function testLocationFactoryGetCurrentLocationExists()
    {
        $class = new \ReflectionClass('\StoreCore\LocationFactory');
        $this->assertTrue($class->hasMethod('getCurrentLocation'));
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @testdox LocationFactory::getCurrentLocation() is public
     */
    public function testLocationFactoryGetCurrentLocationIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\LocationFactory', 'getCurrentLocation');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @testdox LocationFactory::getCurrentLocation() is static
     */
    public function testLocationFactoryGetCurrentLocationIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\LocationFactory', 'getCurrentLocation');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @testdox LocationFactory::getCurrentLocation() has no parameters
     */
    public function testLocationFactoryGetCurrentLocationHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\LocationFactory', 'getCurrentLocation');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @group hmvc
     * @testdox LocationFactory::getCurrentLocation() returns instance of PSR-7 UriInterface
     */
    public function testLocationFactoryGetCurrentLocationReturnsInstanceOfPsr7UriInterface()
    {
        $_SERVER['HTTP_HOST']   = 'www.example.com';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_PORT'] = '80';

        $current_location = \StoreCore\LocationFactory::getCurrentLocation();
        $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $current_location);
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @expectedException \RuntimeException
     * @group hmvc
     * @testdox LocationFactory::getCurrentLocation() throws runtime exception on missing $_SERVER
     */
    public function testLocationFactoryGetCurrentLocationThrowsRuntimeExceptionOnMissingServer()
    {
        unset($_SERVER);
        $current_location = \StoreCore\LocationFactory::getCurrentLocation();
    }

    /**
     * @depends testLocationFactoryGetCurrentLocationExists
     * @expectedException \RuntimeException
     * @group hmvc
     * @testdox LocationFactory::getCurrentLocation() throws runtime exception on empty $_SERVER
     */
    public function testLocationFactoryGetCurrentLocationThrowsRuntimeExceptionOnEmptyServer()
    {
        $_SERVER = array();
        $current_location = \StoreCore\LocationFactory::getCurrentLocation();
    }
}
