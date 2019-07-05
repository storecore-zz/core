<?php
class AMPImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP image class file exists
     */
    public function testAMPImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'Image.php'
        );
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\AMP\LayoutInterface interface file exists
     */
    public function testImplementedStoreCoreAmpLayoutInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'LayoutInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP image implements \StoreCore\AMP\LayoutInterface
     */
    public function testAmpImageImplementsStoreCoreAmpLayoutInterface()
    {
        $object = new \StoreCore\AMP\Image();
        $this->assertInstanceOf(\StoreCore\AMP\LayoutInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\Types\StringableInterface interface file exists
     */
    public function testImplementedStoreCoreTypesStringableInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'StringableInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP image implements \StoreCore\Types\StringableInterface
     */
    public function testAmpImageImplementsStoreCoreTypesStringableInterface()
    {
        $object = new \StoreCore\AMP\Image();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Image');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\Image::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\Image::VERSION);
    }

    /**
     * @depends testVersionConstantIsNotEmpty
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\Image::VERSION);
    }


    /**
     * @testdox Image::__toString() exists
     */
    public function testImageToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Image');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Image::__toString() is public
     */
    public function testImageToStringIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Image::__toString() returns <amp-img> tag
     */
    public function testImageToStringReturnsAmpImgTag()
    {
        $img = new \StoreCore\AMP\Image();
        $this->assertStringStartsWith('<amp-img ', (string)$img);
        $this->assertStringEndsWith('</amp-img>', (string)$img);
    }

    /**
     * @testdox Image::__toString() returns layout="responsive" attribute by default
     */
    public function testImageToStringReturnsLayoutIsResponsiveAttributeByDefault()
    {
        $img = new \StoreCore\AMP\Image();
        $this->assertContains(' layout="responsive"', (string)$img);
    }


    /**
     * @testdox Image::getLayout() exists
     */
    public function testImageGetLayoutExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Image');
        $this->assertTrue($class->hasMethod('getLayout'));
    }

    /**
     * @testdox Image::getLayout() is public
     */
    public function testImageGetLayoutIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'getLayout');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Image::getLayout() has no parameters
     */
    public function testImageGetLayoutHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'getLayout');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox Image::getLayout() returns 'responsive' by default
     */
    public function testImageGetLayoutReturnsResponsiveByDefault()
    {
        $image = new \StoreCore\AMP\Image();
        $this->assertEquals('responsive', $image->getLayout());
    }


    /**
     * @testdox Image::setFallback() exists
     */
    public function testImageSetFallbackExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Image');
        $this->assertTrue($class->hasMethod('setFallback'));
    }

    /**
     * @testdox Image::setFallback() is public
     */
    public function testImageSetFallbackIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'setFallback');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Image::setFallback() has one required parameter
     */
    public function testImageSetFallbackHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'setFallback');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Image::setLightbox() exists
     */
    public function testImageSetLightboxExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Image');
        $this->assertTrue($class->hasMethod('setLightbox'));
    }

    /**
     * @depends testImageSetLightboxExists
     * @testdox Image::setLightbox() is public
     */
    public function testImageSetLightboxIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'setLightbox');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testImageSetLightboxExists
     * @testdox Image::setLightbox() has one optional parameter
     */
    public function testImageSetFallbackHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Image', 'setLightbox');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }
}
