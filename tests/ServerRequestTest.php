<?php
class ServerRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox ServerRequest class file exists
     */
    public function testServerRequestClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'ServerRequest.php');
    }

    /**
     * @group hmvc
     * @testdox ServerRequest class is concrete
     */
    public function testServerRequestClassIsConcrete()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInstantiable());
    }


    /**
     * @group distro
     * @testdox Extended Request class file exists
     */
    public function testExtendedRequestClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Request.php');
    }

    /**
     * @group hmvc
     * @testdox ServerRequest is a Request
     */
    public function testServerRequestIsARequest()
    {
        $request = new \StoreCore\ServerRequest();
        $this->assertInstanceOf(\StoreCore\Request::class, $request);
    }

    /**
     * @group distro
     * @testdox Implemented ServerRequestInterface interface file exists
     */
    public function testImplementedServerRequestInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Psr' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Message' . DIRECTORY_SEPARATOR . 'ServerRequestInterface.php');
    }

    /**
     * @depends testServerRequestClassIsConcrete
     * @group hmvc
     * @testdox ServerRequest implements PSR-7 ServerRequestInterface
     */
    public function testServerRequestImplementsPsr7ServerRequestInterface()
    {
        $class = new \StoreCore\ServerRequest();
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $class);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\ServerRequest::VERSION);
        $this->assertInternalType('string', \StoreCore\ServerRequest::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\ServerRequest::VERSION);
    }


    /**
     * @testdox ServerRequest::getAttribute() exists
     */
    public function testServerRequestGetAttributeExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getAttribute'));
    }

    /**
     * @depends testServerRequestGetAttributeExists
     * @testdox ServerRequest::getAttribute() is public
     */
    public function testServerRequestGetAttributeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getAttribute');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetAttributeExists
     * @testdox ServerRequest::getAttribute() has two parameters
     */
    public function testServerRequestGetAttributeHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getAttribute');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @depends testServerRequestGetAttributeHasTwoParameters
     * @testdox ServerRequest::getAttribute() has one required parameter
     */
    public function testServerRequestGetAttributeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getAttribute');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestGetAttributeHasTwoParameters
     * @testdox ServerRequest::getAttribute() returns second parameter if attribute does not exist
     */
    public function testServerRequestGetAttributeReturnsSecondParameterIfAttributeDoesNotExist()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertNull($server_request->getAttribute('foo'));
        $this->assertEquals('bar', $server_request->getAttribute('foo', 'bar'));
        $this->assertFalse($server_request->getAttribute('foo', false));
    }


    /**
     * @testdox ServerRequest::getAttributes() exists
     */
    public function testServerRequestGetAttributesExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getAttributes'));
    }

    /**
     * @depends testServerRequestGetAttributesExists
     * @testdox ServerRequest::getAttributes() is public
     */
    public function testServerRequestGetAttributesIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getAttributes');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetAttributesExists
     * @testdox ServerRequest::getAttributes() has no parameters
     */
    public function testServerRequestGetAttributesHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getAttributes');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestGetAttributesExists
     * @depends testServerRequestGetAttributesHasNoParameters
     * @testdox ServerRequest::getAttributes() returns empty array by default
     */
    public function testServerRequestGetAttributesReturnsEmptyArrayByDefault()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertEmpty($server_request->getAttributes());
        $this->assertInternalType('array', $server_request->getAttributes());
    }


    /**
     * @testdox ServerRequest::getCookieParams() exists
     */
    public function testServerRequestGetCookieParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getCookieParams'));
    }

    /**
     * @depends testServerRequestGetCookieParamsExists
     * @testdox ServerRequest::getCookieParams() is public
     */
    public function testServerRequestGetCookieParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getCookieParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetCookieParamsExists
     * @testdox ServerRequest::getCookieParams() has no parameters
     */
    public function testServerRequestGetCookieParamsHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getCookieParams');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestGetCookieParamsHasNoParameters
     * @testdox ServerRequest::getCookieParams() returns array
     */
    public function testServerRequestGetCookieParamsReturnsArray()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertInternalType('array', $server_request->getCookieParams());
    }


    /**
     * @testdox ServerRequest::getQueryParams() exists
     */
    public function testServerRequestGetQueryParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getQueryParams'));
    }

    /**
     * @depends testServerRequestGetQueryParamsExists
     * @testdox ServerRequest::getQueryParams() is public
     */
    public function testServerRequestGetQueryParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getQueryParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetQueryParamsExists
     * @testdox ServerRequest::getQueryParams() has no parameters
     */
    public function testServerRequestGetQueryParamsHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getQueryParams');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestGetQueryParamsHasNoParameters
     * @testdox ServerRequest::getQueryParams() returns array
     */
    public function testServerRequestGetQueryParamsReturnsArray()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertInternalType('array', $server_request->getQueryParams());
    }


    /**
     * @testdox ServerRequest::getRemoteAddress() exists
     */
    public function testServerRequestGetRemoteAddressExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getRemoteAddress'));
    }

    /**
     * @depends testServerRequestGetRemoteAddressExists
     * @testdox ServerRequest::getRemoteAddress() is public
     */
    public function testServerRequestGetRemoteAddressIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getRemoteAddress');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetRemoteAddressExists
     * @testdox ServerRequest::getRemoteAddress() has no parameters
     */
    public function testServerRequestGetRemoteAddressHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getRemoteAddress');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestGetRemoteAddressExists
     * @depends testServerRequestGetRemoteAddressHasNoParameters
     * @testdox ServerRequest::getRemoteAddress() returns string
     */
    public function testServerRequestGetRemoteAddressReturnsString()
    {
        $request = new \StoreCore\ServerRequest();
        $this->assertInternalType('string', $request->getRemoteAddress());
    }


    /**
     * @testdox ServerRequest::getServerParams() exists
     */
    public function testServerRequestGetServerParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getServerParams'));
    }

    /**
     * @depends testServerRequestGetServerParamsExists
     * @testdox ServerRequest::getServerParams() is public
     */
    public function testServerRequestGetServerParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getServerParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetServerParamsExists
     * @testdox ServerRequest::getServerParams() has no parameters
     */
    public function testServerRequestGetServerParamsHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getServerParams');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox ServerRequest::getServerParams() returns non-empty array
     */
    public function testServerRequestGetServerParamsReturnsNonEmptyArray()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertNotEmpty($server_request->getServerParams());
        $this->assertInternalType('array', $server_request->getServerParams());
    }


    /**
     * @testdox ServerRequest::getUploadedFiles() exists
     */
    public function testServerRequestGetUploadedFilesExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('getUploadedFiles'));
    }

    /**
     * @depends testServerRequestGetUploadedFilesExists
     * @testdox ServerRequest::getUploadedFiles() is public
     */
    public function testServerRequestGetUploadedFilesIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getUploadedFiles');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestGetUploadedFilesExists
     * @testdox ServerRequest::getUploadedFiles() has no parameters
     */
    public function testServerRequestGetUploadedFilesHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'getUploadedFiles');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestGetUploadedFilesHasNoParameters
     * @testdox ServerRequest::getUploadedFiles() returns empty array by default
     */
    public function testServerRequestGetUploadedFilesReturnsEmptyArrayByDefault()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertEmpty($server_request->getUploadedFiles());
        $this->assertInternalType('array', $server_request->getUploadedFiles());
    }


    /**
     * @testdox ServerRequest::isSecure() exists
     */
    public function testServerRequestIsSecureExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('isSecure'));
    }

    /**
     * @depends testServerRequestIsSecureExists
     * @testdox ServerRequest::isSecure() is public
     */
    public function testServerRequestIsSecureIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'isSecure');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestIsSecureExists
     * @testdox ServerRequest::isSecure() has no parameters
     */
    public function testServerRequestIsSecureHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'isSecure');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testServerRequestIsSecureExists
     * @depends testServerRequestIsSecureHasNoParameters
     * @testdox ServerRequest::isSecure() returns boolean
     */
    public function testServerRequestIsSecureReturnsBoolean()
    {
        $request = new \StoreCore\ServerRequest();
        $this->assertInternalType('bool', $request->isSecure());
    }

    /**
     * @depends testServerRequestIsSecureReturnsBoolean
     * @testdox ServerRequest::isSecure() returns false by default
     */
    public function testServerRequestIsSecureReturnsFalseByDefault()
    {
        $request = new \StoreCore\ServerRequest();
        $this->assertFalse($request->isSecure());
    }


    /**
     * @testdox ServerRequest::setAttribute() exists
     */
    public function testServerRequestSetAttributeExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setAttribute'));
    }

    /**
     * @depends testServerRequestSetAttributeExists
     * @testdox ServerRequest::setAttribute() is public
     */
    public function testServerRequestSetAttributeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setAttribute');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetAttributeExists
     * @testdox ServerRequest::setAttribute() has two required parameters
     */
    public function testServerRequestSetAttributeHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setAttribute');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }


    /**
     * @testdox ServerRequest::setCookieParams() exists
     */
    public function testServerRequestSetCookieParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setCookieParams'));
    }

    /**
     * @depends testServerRequestSetCookieParamsExists
     * @testdox ServerRequest::setCookieParams() is public
     */
    public function testServerRequestSetCookieParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setCookieParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetCookieParamsExists
     * @testdox ServerRequest::setCookieParams() has one required parameter
     */
    public function testServerRequestSetCookieParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setCookieParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox ServerRequest::setParsedBody() exists
     */
    public function testServerRequestSetParsedBodyExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setParsedBody'));
    }

    /**
     * @depends testServerRequestSetParsedBodyExists
     * @testdox ServerRequest::setParsedBody() is public
     */
    public function testServerRequestSetParsedBodyIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setParsedBody');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetParsedBodyExists
     * @testdox ServerRequest::setParsedBody() has one required parameter
     */
    public function testServerRequestSetParsedBodyHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setParsedBody');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestSetParsedBodyExists
     * @testdox ServerRequest::setParsedBody() sets server request body
     */
    public function testServerRequestSetParsedBodyReturnsPsr7ServerRequestInterface()
    {
        // HTTP POST request
        $_POST = array(
            'name'  => 'Alice Bob',
            'email' => 'alice@example.com',
        );

        $request = new \StoreCore\ServerRequest();
        $this->assertNull($request->getParsedBody());

        $request->setParsedBody($_POST);
        $this->assertEquals($_POST, $request->getParsedBody());
    }


    /**
     * @testdox ServerRequest::setQueryParams() exists
     */
    public function testServerRequestSetQueryParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setQueryParams'));
    }

    /**
     * @depends testServerRequestSetQueryParamsExists
     * @testdox ServerRequest::setQueryParams() is public
     */
    public function testServerRequestSetQueryParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setQueryParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetQueryParamsExists
     * @testdox ServerRequest::setQueryParams() has one required parameter
     */
    public function testServerRequestSetQueryParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setQueryParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox ServerRequest::setServerParams() exists
     */
    public function testServerRequestSetServerParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setServerParams'));
    }

    /**
     * @depends testServerRequestSetServerParamsExists
     * @testdox ServerRequest::setServerParams() is public
     */
    public function testServerRequestSetServerParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setServerParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetServerParamsExists
     * @testdox ServerRequest::setServerParams() has one required parameter
     */
    public function testServerRequestSetServerParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setServerParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox ServerRequest::setUploadedFiles() exists
     */
    public function testServerRequestSetUploadedFilesExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('setUploadedFiles'));
    }

    /**
     * @depends testServerRequestSetUploadedFilesExists
     * @testdox ServerRequest::setUploadedFiles() is public
     */
    public function testServerRequestSetUploadedFilesIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setUploadedFiles');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestSetUploadedFilesExists
     * @testdox ServerRequest::setUploadedFiles() has one required parameter
     */
    public function testServerRequestSetUploadedFilesHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'setUploadedFiles');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox ServerRequest::unsetAttribute() exists
     */
    public function testServerRequestUnsetAttributeExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('unsetAttribute'));
    }

    /**
     * @depends testServerRequestUnsetAttributeExists
     * @testdox ServerRequest::unsetAttribute() is public
     */
    public function testServerRequestUnsetAttributeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'unsetAttribute');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestUnsetAttributeExists
     * @testdox ServerRequest::unsetAttribute() has one required parameter
     */
    public function testServerRequestUnsetAttributeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'unsetAttribute');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestUnsetAttributeHasOneRequiredParameter
     * @testdox ServerRequest::unsetAttribute() returns true on success
     */
    public function testServerRequestUnsetAttributeReturnsTrueOnSuccess()
    {
        $server_request = new \StoreCore\ServerRequest();
        $server_request->setAttribute('foo', 'bar');
        $this->assertTrue($server_request->unsetAttribute('foo'));
    }

    /**
     * @depends testServerRequestUnsetAttributeHasOneRequiredParameter
     * @testdox ServerRequest::unsetAttribute() returns false if attribute does not exist
     */
    public function testServerRequestUnsetAttributeReturnsFalseIfAttributeDoesNotExist()
    {
        $server_request = new \StoreCore\ServerRequest();
        $this->assertFalse($server_request->unsetAttribute('foo'));
    }


    /**
     * @testdox ServerRequest::withAttribute() exists
     */
    public function testServerRequestWithAttributeExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withAttribute'));
    }

    /**
     * @depends testServerRequestWithAttributeExists
     * @testdox ServerRequest::withAttribute() is public
     */
    public function testServerRequestWithAttributeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withAttribute');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithAttributeExists
     * @testdox ServerRequest::withAttribute() has two required parameters
     */
    public function testServerRequestWithAttributeHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withAttribute');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }

    /**
     * @depends testServerRequestWithAttributeExists
     * @testdox ServerRequest::withAttribute() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithAttributeReturnsPsr7ServerRequestInterface()
    {
        $request = new \StoreCore\ServerRequest();
        $new_request_instance = $request->withAttribute('foo', 'bar');
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withoutAttribute() exists
     */
    public function testServerRequestWithoutAttributeExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withoutAttribute'));
    }

    /**
     * @depends testServerRequestWithoutAttributeExists
     * @testdox ServerRequest::withoutAttribute() is public
     */
    public function testServerRequestWithoutAttributeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withoutAttribute');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithoutAttributeExists
     * @testdox ServerRequest::withoutAttribute() has one required parameter
     */
    public function testServerRequestWithoutAttributeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withoutAttribute');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestWithoutAttributeExists
     * @testdox ServerRequest::withoutAttribute() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithoutAttributeReturnsPsr7ServerRequestInterface()
    {
        $request = new \StoreCore\ServerRequest();
        $request->setAttribute('foo', 'bar');

        $new_request_instance = $request->withoutAttribute('foo', 'bar');
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withCookieParams() exists
     */
    public function testServerRequestWithCookieParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withCookieParams'));
    }

    /**
     * @depends testServerRequestWithCookieParamsExists
     * @testdox ServerRequest::withCookieParams() is public
     */
    public function testServerRequestWithCookieParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withCookieParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithCookieParamsExists
     * @testdox ServerRequest::withCookieParams() has one required parameter
     */
    public function testServerRequestWithCookieParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withCookieParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestWithCookieParamsExists
     * @testdox ServerRequest::withCookieParams() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithCookieParamsReturnsPsr7ServerRequestInterface()
    {
        $request = new \StoreCore\ServerRequest();
        $params = array('PHPSESSID' => 'engjq09365i8jukojlbpvk36t0');
        $new_request_instance = $request->withCookieParams($params);
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withParsedBody() exists
     */
    public function testServerRequestWithParsedBodyExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withParsedBody'));
    }

    /**
     * @depends testServerRequestWithParsedBodyExists
     * @testdox ServerRequest::withParsedBody() is public
     */
    public function testServerRequestWithParsedBodyIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withParsedBody');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithParsedBodyExists
     * @testdox ServerRequest::withParsedBody() has one required parameter
     */
    public function testServerRequestWithParsedBodyHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withParsedBody');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestWithParsedBodyExists
     * @testdox ServerRequest::withParsedBody() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithParsedBodyReturnsPsr7ServerRequestInterface()
    {
        // HTTP POST request
        $_POST = array(
            'name'  => 'Alice Bob',
            'email' => 'alice@example.com',
        );

        $request = new \StoreCore\ServerRequest();
        $new_request_instance = $request->withParsedBody($_POST);
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withQueryParams() exists
     */
    public function testServerRequestWithQueryParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withQueryParams'));
    }

    /**
     * @depends testServerRequestWithQueryParamsExists
     * @testdox ServerRequest::withQueryParams() is public
     */
    public function testServerRequestWithQueryParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withQueryParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithQueryParamsExists
     * @testdox ServerRequest::withQueryParams() has one required parameter
     */
    public function testServerRequestWithQueryParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withQueryParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestWithQueryParamsExists
     * @testdox ServerRequest::withQueryParams() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithQueryParamsReturnsPsr7ServerRequestInterface()
    {
        // URL with `?q=foo+bar&hl=en` query string
        $query = array(
            'q'  => 'foo bar',
            'hl' => 'en',
        );

        $request = new \StoreCore\ServerRequest();
        $new_request_instance = $request->withQueryParams($query);
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withServerParams() exists
     */
    public function testServerRequestWithServerParamsExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withServerParams'));
    }

    /**
     * @depends testServerRequestWithServerParamsExists
     * @testdox ServerRequest::withServerParams() is public
     */
    public function testServerRequestWithServerParamsIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withServerParams');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithServerParamsExists
     * @testdox ServerRequest::withServerParams() has one required parameter
     */
    public function testServerRequestWithServerParamsHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withServerParams');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testServerRequestWithServerParamsExists
     * @testdox ServerRequest::withServerParams() returns PSR-7 ServerRequestInterface
     */
    public function testServerRequestWithServerParamsReturnsPsr7ServerRequestInterface()
    {
        // Basic HTTP request
        $params = array(
            'SERVER_ADDR'     => '::1',
            'SERVER_PORT'     => '80',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
        );

        $request = new \StoreCore\ServerRequest();
        $new_request_instance = $request->withServerParams($params);
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $new_request_instance);
    }


    /**
     * @testdox ServerRequest::withUploadedFiles() exists
     */
    public function testServerRequestWithUploadedFilesExists()
    {
        $class = new \ReflectionClass('\StoreCore\ServerRequest');
        $this->assertTrue($class->hasMethod('withUploadedFiles'));
    }

    /**
     * @depends testServerRequestWithUploadedFilesExists
     * @testdox ServerRequest::withUploadedFiles() is public
     */
    public function testServerRequestWithUploadedFilesIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withUploadedFiles');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testServerRequestWithUploadedFilesExists
     * @testdox ServerRequest::withUploadedFiles() has one required parameter
     */
    public function testServerRequestWithUploadedFilesHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\ServerRequest', 'withUploadedFiles');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
