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
     * @group distro
     * @testdox Implemented StringableInterface interface file exists
     */
    public function testImplementedStringableInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'StringableInterface.php');
    }

    /**
     * @group hmvc
     * @testdox Location model implements \StoreCore\Types\StringableInterface
     */
    public function testLocationModelImplementsStoreCoreTypesStringableInterface()
    {
        $location = new \StoreCore\Location();
        $this->assertInstanceOf('\StoreCore\Types\StringableInterface', $location);
    }


    /**
     * @group distro
     * @testdox Implemented PSR UriInterface interface file exists
     */
    public function testImplementedPsrUriInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'UriInterface.php');
    }

    /**
     * @group hmvc
     * @testdox Location implements PSR UriInterface
     */
    public function testLocationImplementsPsrUriInterface()
    {
        $location = new \StoreCore\Location();
        $this->assertInstanceOf('\Psr\Http\Message\UriInterface', $location);
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
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Location::VERSION);
        $this->assertInternalType('string', \StoreCore\Location::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.2.0', \StoreCore\Location::VERSION);
    }


    /**
     * @testdox Location::__construct() exists
     */
    public function testLocationConstructExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('__construct'));
    }

    /**
     * @depends testLocationConstructExists
     * @testdox Location::__construct() is public
     */
    public function testLocationConstructIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', '__construct');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationConstructExists
     * @testdox Location::__construct() has one optional parameter
     */
    public function testLocationConstructHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', '__construct');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }


    /**
     * @testdox Location::__toString() exists
     */
    public function testLocationToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testLocationToStringExists
     * @testdox Location::__toString() is public
     */
    public function testLocationToStringIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', '__toString');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox Location::get() exists
     */
    public function testLocationGetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('get'));
    }

    /**
     * @depends testLocationGetExists
     * @testdox Location::get() is public
     */
    public function testLocationGetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'get');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Location::get() has no parameters
     */
    public function testLocationGetHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'get');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Location::get() returns string
     */
    public function testLocationGetReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertTrue(is_string($location->get()));
    }


    /**
     * @testdox Location::getAuthority() exists
     */
    public function testLocationGetAuthorityExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getAuthority'));
    }

    /**
     * @depends testLocationGetAuthorityExists
     * @testdox Location::getAuthority() is public
     */
    public function testLocationGetAuthorityIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getAuthority');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetAuthorityExists
     * @depends testLocationGetAuthorityIsPublic
     * @testdox Location::getAuthority() returns string
     */
    public function testLocationGetAuthorityReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertInternalType('string', $location->getAuthority());
    }

    /**
     * @depends testLocationGetAuthorityReturnsString
     * @testdox Location::getAuthority() returns empty string if no authority is present
     */
    public function testLocationGetAuthorityReturnsEmptyStringIfNoAuthorityIsPresent()
    {
        $location = new \StoreCore\Location();
        $this->assertEmpty($location->getAuthority());
    }


    /**
     * @testdox Location::getFragment() exists
     */
    public function testLocationGetFragmentExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getFragment'));
    }

    /**
     * @depends testLocationGetFragmentExists
     * @testdox Location::getFragment() is public
     */
    public function testLocationGetFragmentIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getFragment');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetFragmentExists
     * @depends testLocationGetFragmentIsPublic
     * @testdox Location::getFragment() returns string
     */
    public function testLocationGetFragmentReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertInternalType('string', $location->getFragment());
    }

    /**
     * @depends testLocationGetFragmentReturnsString
     * @testdox Location::getFragment() returns empty string if no fragment is present
     */
    public function testLocationGetFragmentReturnsEmptyStringIfNoFragmentIsPresent()
    {
        $location = new \StoreCore\Location();
        $this->assertEmpty($location->getFragment());
    }


    /**
     * @testdox Location::getHost() exists
     */
    public function testLocationGetHostExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getHost'));
    }

    /**
     * @depends testLocationGetHostExists
     * @testdox Location::getHost() is public
     */
    public function testLocationGetHostIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getHost');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetHostExists
     * @depends testLocationGetHostIsPublic
     * @testdox Location::getHost() returns string
     */
    public function testLocationGetHostReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertInternalType('string', $location->getHost());
    }

    /**
     * @depends testLocationGetHostReturnsString
     * @testdox Location::getHost() returns empty string if no host is present
     */
    public function testLocationGetHostReturnsEmptyStringIfNoHostIsPresent()
    {
        $location = new \StoreCore\Location();
        $this->assertEmpty($location->getHost());
    }


    /**
     * @testdox Location::getPath() exists
     */
    public function testLocationGetPathExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getPath'));
    }

    /**
     * @depends testLocationGetPathExists
     * @testdox Location::getPath() is public
     */
    public function testLocationGetPathIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getPath');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetPathExists
     * @depends testLocationGetPathIsPublic
     * @testdox Location::getPath() returns string
     */
    public function testLocationGetPathReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertInternalType('string', $location->getPath());
    }

    /**
     * @depends testLocationGetPathReturnsString
     * @testdox Location::getPath() returns empty string if no path is present
     */
    public function testLocationGetPathReturnsEmptyStringIfNoPathIsPresent()
    {
        $location = new \StoreCore\Location();
        $this->assertEmpty($location->getPath());
    }


    /**
     * @testdox Location::getPort() exists
     */
    public function testLocationGetPortExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getPort'));
    }

    /**
     * @depends testLocationGetPortExists
     * @testdox Location::getPort() is public
     */
    public function testLocationGetPortIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getPort');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetPortExists
     * @testdox Location::getPort() has no parameters
     */
    public function testLocationGetPortHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getPort');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testLocationGetPortExists
     * @testdox Location::getPort() returns null by default
     */
    public function testLocationGetPortReturnsNullByDefault()
    {
        $location = new \StoreCore\Location();
        $this->assertNull($location->getPort());
    }


    /**
     * @testdox Location::getQuery() exists
     */
    public function testLocationGetQueryExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getQuery'));
    }

    /**
     * @depends testLocationGetQueryExists
     * @testdox Location::getQuery() is public
     */
    public function testLocationGetQueryIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getQuery');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetQueryExists
     * @testdox Location::getQuery() has no parameters
     */
    public function testLocationGetQueryHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getQuery');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Location::getScheme() exists
     */
    public function testLocationGetSchemeExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getScheme'));
    }

    /**
     * @depends testLocationGetSchemeExists
     * @testdox Location::getScheme() is public
     */
    public function testLocationGetSchemeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getScheme');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetSchemeExists
     * @testdox Location::getScheme() has no parameters
     */
    public function testLocationGetSchemeHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getScheme');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testLocationGetSchemeExists
     * @depends testLocationGetSchemeIsPublic
     * @testdox Location::getScheme() returns string
     */
    public function testLocationGetSchemeReturnsString()
    {
        $location = new \StoreCore\Location();
        $this->assertEmpty($location->getScheme());
    }

    /**
     * @depends testLocationGetSchemeReturnsString
     * @testdox Location::getScheme() returns empty string if no scheme is present
     */
    public function testLocationGetSchemeReturnsEmptyStringIfNoSchemeIsPresent()
    {
        $location = new \StoreCore\Location();
        $this->assertInternalType('string', $location->getScheme());
    }


    /**
     * @testdox Location::getUserInfo() exists
     */
    public function testLocationGetUserInfoExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('getUserInfo'));
    }

    /**
     * @depends testLocationGetUserInfoExists
     * @testdox Location::getUserInfo() is public
     */
    public function testLocationGetUserInfoIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getUserInfo');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationGetUserInfoExists
     * @testdox Location::getUserInfo() has no parameters
     */
    public function testLocationGetUserInfoHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'getUserInfo');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Location::set() exists
     */
    public function testLocationSetExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('set'));
    }

    /**
     * @depends testLocationSetExists
     * @testdox Location::set() is public
     */
    public function testLocationSetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'set');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetExists
     * @testdox Location::set() has one required parameter
     */
    public function testLocationSetHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'set');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setAuthority() exists
     */
    public function testLocationSetAuthorityExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setAuthority'));
    }

    /**
     * @depends testLocationSetAuthorityExists
     * @testdox Location::setAuthority() is public
     */
    public function testLocationSetAuthorityIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setAuthority');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetAuthorityExists
     * @testdox Location::setAuthority() has one required parameters
     */
    public function testLocationSetAuthorityHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setAuthority');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setFragment() exists
     */
    public function testLocationSetFragmentExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setFragment'));
    }

    /**
     * @depends testLocationSetFragmentExists
     * @testdox Location::setFragment() is public
     */
    public function testLocationSetFragmentIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setFragment');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetFragmentExists
     * @testdox Location::setFragment() has one required parameters
     */
    public function testLocationSetFragmentHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setFragment');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setHost() exists
     */
    public function testLocationSetHostExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setHost'));
    }

    /**
     * @depends testLocationSetHostExists
     * @testdox Location::setHost() is public
     */
    public function testLocationSetHostIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setHost');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetHostExists
     * @testdox Location::setHost() has one required parameters
     */
    public function testLocationSetHostHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setHost');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setPath() exists
     */
    public function testLocationSetPathExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setPath'));
    }

    /**
     * @depends testLocationSetPathExists
     * @testdox Location::setPath() is public
     */
    public function testLocationSetPathIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setPath');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetPathExists
     * @testdox Location::setPath() has one required parameters
     */
    public function testLocationSetPathHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setPath');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testLocationSetPathExists
     * @depends testLocationSetPathHasOneRequiredParameter
     * @expectedException \InvalidArgumentException
     * @testdox Location::setPath() throws \InvalidArgumentException for wrong data type
     */
    public function testLocationSetPathThrowsInvalidArgumentExceptionForWrongDataType()
    {
        $location =  new \StoreCore\Location();
        $location->setPath(true);
    }

    /**
     * @depends testLocationSetPathExists
     * @depends testLocationSetPathHasOneRequiredParameter
     * @testdox Location::setPath() accepts empty path
     */
    public function testLocationSetPathAcceptsEmptyPath()
    {
        $location =  new \StoreCore\Location();
        $location->set('');
        $this->assertEmpty($location->getPath());
        $this->assertInternalType('string', $location->getPath());
    }


    /**
     * @testdox Location::setPort() exists
     */
    public function testLocationSetPortExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setPort'));
    }

    /**
     * @depends testLocationSetPortExists
     * @testdox Location::setPort() is public
     */
    public function testLocationSetPortIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setPort');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetPortExists
     * @testdox Location::setPort() has one required parameters
     */
    public function testLocationSetPortHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setPort');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setQuery() exists
     */
    public function testLocationSetQueryExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setQuery'));
    }

    /**
     * @depends testLocationSetQueryExists
     * @testdox Location::setQuery() is public
     */
    public function testLocationSetQueryIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setQuery');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetQueryExists
     * @testdox Location::setQuery() has one required parameter
     */
    public function testLocationSetQueryHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setQuery');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::setScheme() exists
     */
    public function testLocationSetSchemeExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setScheme'));
    }

    /**
     * @depends testLocationSetSchemeExists
     * @testdox Location::setScheme() is public
     */
    public function testLocationSetSchemeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setScheme');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetSchemeExists
     * @testdox Location::setScheme() has one required parameter
     */
    public function testLocationSetSchemeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setScheme');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testLocationGetSchemeReturnsString
     * @depends testLocationSetSchemeExists
     * @depends testLocationSetSchemeIsPublic
     * @depends testLocationSetSchemeHasOneRequiredParameter
     * @testdox Location::setScheme() accepts 'http' scheme
     */
    public function testLocationSetSchemeAcceptsHttpScheme()
    {
        $location = new \StoreCore\Location();
        $location->setScheme('http');
        $this->assertEquals('http', $location->getScheme());
    }

    /**
     * @depends testLocationGetSchemeReturnsString
     * @depends testLocationSetSchemeExists
     * @depends testLocationSetSchemeIsPublic
     * @depends testLocationSetSchemeHasOneRequiredParameter
     * @testdox Location::setScheme() accepts 'https' scheme
     */
    public function testLocationSetSchemeAcceptsHttpsScheme()
    {
        $location = new \StoreCore\Location();
        $location->setScheme('https');
        $this->assertEquals('https', $location->getScheme());
    }

    /**
     * @depends testLocationSetSchemeAcceptsHttpScheme
     * @depends testLocationSetSchemeAcceptsHttpsScheme
     * @testdox Location::getScheme() returns set scheme
     */
    public function testLocationGetSchemeReturnsSetScheme()
    {
        $location = new \StoreCore\Location();

        $location->setScheme('http');
        $this->assertEquals('http', $location->getScheme());

        $location->setScheme('https');
        $this->assertEquals('https', $location->getScheme());
    }

    /**
     * @testdox Location::setScheme() is case insensitive
     */
    public function testLocationSetSchemeIsCaseInsensitive()
    {
        $location = new \StoreCore\Location();
        $location->setScheme('HTTPS');
        $this->assertEquals('https', $location->getScheme());
        $location->setScheme('HTTPs');
        $this->assertEquals('https', $location->getScheme());
    }


    /**
     * @depends testLocationSetSchemeAcceptsHttpScheme
     * @testdox Location::getPort() returns null on default HTTP port
     */
    public function testLocationGetPortReturnNullOnDefaultHttpPort()
    {
        $location = new \StoreCore\Location();

        $location->setPort(80);
        $this->assertNotNull($location->getPort());
        $location->setScheme('http');
        $this->assertNull($location->getPort());

        $location->setPort(8008);
        $this->assertNotNull($location->getPort());

        $location->setPort(8080);
        $this->assertNotNull($location->getPort());
    }

    /**
     * @depends testLocationSetSchemeAcceptsHttpsScheme
     * @see https://stackoverflow.com/questions/32478277/is-there-any-standard-alternative-https-port
     * @testdox Location::getPort() returns null on default HTTPS port
     */
    public function testLocationGetPortReturnNullOnDefaultHttpsPort()
    {
        $location = new \StoreCore\Location();

        $location->setPort(443);
        $this->assertNotNull($location->getPort());
        $location->setScheme('https');
        $this->assertNull($location->getPort());

        $location->setPort(8443);
        $this->assertNotNull($location->getPort());
    }


    /**
     * @testdox Location::setUserInfo() exists
     */
    public function testLocationSetUserInfoExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('setUserInfo'));
    }

    /**
     * @depends testLocationSetUserInfoExists
     * @testdox Location::setUserInfo() is public
     */
    public function testLocationSetUserInfoIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setUserInfo');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationSetUserInfoExists
     * @testdox Location::setUserInfo() has two parameters
     */
    public function testLocationSetUserInfoHasTwoParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setUserInfo');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testLocationSetUserInfoExists
     * @testdox Location::setUserInfo() has one required parameter
     */
    public function testLocationSetUserInfoHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'setUserInfo');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox Location::setAuthority() sets optional user information
     */
    public function testLocationSetAuthoritySetsOptionalUserInformation()
    {
        $location = new \StoreCore\Location();

        $location->setAuthority('alice@example.com');
        $this->assertSame('alice', $location->getUserInfo());

        $location->setAuthority('bob:secret@example.com');
        $this->assertSame('bob:secret', $location->getUserInfo());

        $location->setAuthority('bob:secret@example.com:8080');
        $this->assertSame('bob:secret', $location->getUserInfo());
    }


    /**
     * @testdox Location::unsetPort() exists
     */
    public function testLocationUnsetPortExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('unsetPort'));
    }

    /**
     * @depends testLocationUnsetPortExists
     * @testdox Location::unsetPort() is public
     */
    public function testLocationUnsetPortIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'unsetPort');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationUnsetPortExists
     * @testdox Location::unsetPort() has no parameters
     */
    public function testLocationUnsetPortHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'unsetPort');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }


    /**
     * @testdox Location::withFragment() exists
     */
    public function testLocationWithFragmentExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withFragment'));
    }

    /**
     * @depends testLocationWithFragmentExists
     * @testdox Location::withFragment() is public
     */
    public function testLocationWithFragmentIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withFragment');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithFragmentExists
     * @testdox Location::withFragment() has one required parameter
     */
    public function testLocationWithFragmentHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withFragment');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::withHost() exists
     */
    public function testLocationWithHostExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withHost'));
    }

    /**
     * @depends testLocationWithHostExists
     * @testdox Location::withHost() is public
     */
    public function testLocationWithHostIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withHost');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithHostExists
     * @testdox Location::withHost() has one required parameter
     */
    public function testLocationWithHostHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withHost');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::withPath() exists
     */
    public function testLocationWithPathExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withPath'));
    }

    /**
     * @depends testLocationWithPathExists
     * @testdox Location::withPath() is public
     */
    public function testLocationWithPathIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withPath');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithPathExists
     * @testdox Location::withPath() has one required parameter
     */
    public function testLocationWithPathHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withPath');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::withPort() exists
     */
    public function testLocationWithPortExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withPort'));
    }

    /**
     * @depends testLocationWithPortExists
     * @testdox Location::withPort() is public
     */
    public function testLocationWithPortIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withPort');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithPortExists
     * @testdox Location::withPort() has one required parameter
     */
    public function testLocationWithPortHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withPort');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::withQuery() exists
     */
    public function testLocationWithQueryExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withQuery'));
    }

    /**
     * @depends testLocationWithQueryExists
     * @testdox Location::withQuery() is public
     */
    public function testLocationWithQueryIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withQuery');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithQueryExists
     * @testdox Location::withQuery() has one required parameter
     */
    public function testLocationWithQueryHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withQuery');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Location::withScheme() exists
     */
    public function testLocationWithSchemeExists()
    {
        $class = new \ReflectionClass('\StoreCore\Location');
        $this->assertTrue($class->hasMethod('withScheme'));
    }

    /**
     * @depends testLocationWithSchemeExists
     * @testdox Location::withScheme() is public
     */
    public function testLocationWithSchemeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withScheme');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testLocationWithSchemeExists
     * @testdox Location::withScheme() has one required parameter
     */
    public function testLocationWithSchemeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Location', 'withScheme');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

}
