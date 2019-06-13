<?php
class AMPIconLibraryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Icon library class file exists
     */
    public function testIconLibraryClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'IconLibrary.php'
        );
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\IconLibrary');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\IconLibrary::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\IconLibrary::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches development branch
     */
    public function testVersionConstantMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\IconLibrary::VERSION);
    }


    /**
     * @testdox IconLibrary class has CodePoints property
     */
    public function testIconLibraryClassHasCodePointsProperty()
    {
        $this->assertClassHasAttribute('CodePoints', \StoreCore\AMP\IconLibrary::class);
    }

    /**
     * @depends testIconLibraryClassHasCodePointsProperty
     * @testdox IconLibrary CodePoints property is protected
     */
    public function testIconLibraryCodePointsPropertyIsProtected()
    {
        $property = new \ReflectionProperty(\StoreCore\AMP\IconLibrary::class, 'CodePoints');
        $this->assertTrue($property->isProtected());
    }


    /**
     * @testdox IconLibrary class has Paths property
     */
    public function testIconLibraryClassHasPathsProperty()
    {
        $this->assertClassHasAttribute('Paths', \StoreCore\AMP\IconLibrary::class);
    }

    /**
     * @depends testIconLibraryClassHasPathsProperty
     * @testdox IconLibrary Paths property is protected
     */
    public function testIconLibraryPathsPropertyIsProtected()
    {
        $property = new \ReflectionProperty(\StoreCore\AMP\IconLibrary::class, 'Paths');
        $this->assertTrue($property->isProtected());
    }


    /**
     * @testdox getCharacter() method exists
     */
    public function testGetCharacterMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\IconLibrary');
        $this->assertTrue($class->hasMethod('getCharacter'));
    }

    /**
     * @depends testGetCharacterMethodExists
     * @testdox getCharacter() method is public
     */
    public function testGetgetCharacterMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getCharacter');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testGetCharacterMethodExists
     * @testdox getCharacter() method has one parameter
     */
    public function testGetCharacterMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getCharacter');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testGetCharacterMethodHasOneParameter
     * @testdox getCharacter() method parameter is required
     */
    public function testGetCharacterMethodParameterIsRequired()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getCharacter');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testGetCharacterMethodHasOneParameter
     * @testdox getCharacter() method returns non-empty string
     */
    public function testGetCharacterMethodReturnsNonEmptyString()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertNotEmpty($icon_library->getCharacter('home'));
        $this->assertInternalType('string', $icon_library->getCharacter('home'));
    }

    /**
     * @depends testGetCharacterMethodReturnsNonEmptyString
     * @testdox getCharacter() method returns HTML character entity
     */
    public function testGetCharacterMethodReturnsHtmlCharacterEntity()
    {
        $charmap = array(
            'home'          => '&#xE88A;',
            'search'        => '&#xE8B6;',
            'shopping_cart' => '&#xE8CC;',
        );

        $icon_library = new \StoreCore\AMP\IconLibrary();
        foreach ($charmap as $input => $output) {
            $this->assertSame($output, $icon_library->getCharacter($input));
        }
    }

    /**
     * @depends testGetCharacterMethodReturnsNonEmptyString
     * @testdox getCharacter() method is case-insensitive
     */
    public function testGetCharacterMethodIsCaseInsensitive()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertSame($icon_library->getCharacter('Shopping_Cart'), $icon_library->getCharacter('shopping_cart'));
        $this->assertSame($icon_library->getCharacter('SHOPPING_CART'), $icon_library->getCharacter('Shopping_Cart'));
        $this->assertSame($icon_library->getCharacter('shopping_cart'), $icon_library->getCharacter('SHOPPING_CART'));
    }

    /**
     * @depends testGetCharacterMethodReturnsNonEmptyString
     * @testdox getCharacter() method accepts underscores and spaces
     */
    public function testGetCharacterMethodAcceptsUnderscoresAndSpaces()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertSame($icon_library->getCharacter('shopping basket'), $icon_library->getCharacter('shopping_basket'));
        $this->assertSame($icon_library->getCharacter('shopping cart'), $icon_library->getCharacter('shopping_cart'));
    }


    /**
     * @testdox Public getDataURI() method exists
     */
    public function testPublicGetDataUriMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\IconLibrary');
        $this->assertTrue($class->hasMethod('getDataURI'));
    }

    /**
     * @depends testPublicGetDataUriMethodExists
     * @testdox Public getDataURI() method is public
     */
    public function testPublicGetDataUriMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getDataURI');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetDataUriMethodExists
     * @testdox Public getDataURI() method has one parameter
     */
    public function testPublicGetDataUriMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getDataURI');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testPublicGetDataUriMethodHasOneParameter
     * @testdox Public getDataURI() method parameter is required
     */
    public function testPublicGetDataUriMethodParameterIsRequired()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getDataURI');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox Public getDataURI() method returns non-empty string
     */
    public function testPublicGetDataUriMethodReturnsNonEmptyString()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertNotEmpty($icon_library->getDataURI('Home'));
        $this->assertInternalType('string', $icon_library->getDataURI('Home'));
    }

    /**
     * @testdox Public getDataURI() method returns SVG image data URI
     */
    public function testPublicGetDataUriMethodReturnsSvgImageDataUri()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertStringStartsWith('data:image/svg+xml;', $icon_library->getDataURI('Home'));
    }

    /**
     * @testdox Public getDataURI() method returns Base64 encoded data URI
     */
    public function testPublicGetDataUriMethodReturnsBase64EncodedDataUri()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $icon = $icon_library->getDataURI('Home');
        $this->assertStringStartsWith('data:', $icon);
        $this->assertContains(';base64,', $icon);
    }


    /**
     * @testdox Public getSVG() method exists
     */
    public function testPublicGetSvgMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\IconLibrary');
        $this->assertTrue($class->hasMethod('getSVG'));
    }

    /**
     * @depends testPublicGetSvgMethodExists
     * @testdox Public getSVG() method is public
     */
    public function testPublicGetSvgMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getSVG');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetSvgMethodExists
     * @testdox Public getSVG() method has one parameter
     */
    public function testPublicGetSvgMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getSVG');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testPublicGetSvgMethodHasOneParameter
     * @testdox Public getSVG() method parameter is required
     */
    public function testPublicGetSvgMethodParameterIsRequired()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\IconLibrary', 'getSVG');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testPublicGetSvgMethodHasOneParameter
     * @testdox Public getSVG() method parameter is case insensitive
     */
    public function testPublicGetSvgMethodParameterIsCaseInsensitive()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertSame($icon_library->getSVG('home'), $icon_library->getSVG('HOME'));
        $this->assertSame($icon_library->getSVG('HOME'), $icon_library->getSVG('Home'));
        $this->assertSame($icon_library->getSVG('Home'), $icon_library->getSVG('home'));
    }

    /**
     * @testdox Public getSVG() method returns non-empty string
     */
    public function testPublicGetSvgMethodReturnsNonEmptyString()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $this->assertNotEmpty($icon_library->getSVG('Home'));
        $this->assertInternalType('string', $icon_library->getSVG('Home'));
    }

    /**
     * @testdox Public getSVG() method returns SVG tag
     */
    public function testPublicGetSvgMethodReturnsSvgTag()
    {
        $icon_library = new \StoreCore\AMP\IconLibrary();
        $icon = $icon_library->getSVG('Home');
        $this->assertStringStartsWith('<svg ', $icon);
        $this->assertContains('xmlns="http://www.w3.org/2000/svg"', $icon);
        $this->assertStringEndsWith('</svg>', $icon);
    }
}
