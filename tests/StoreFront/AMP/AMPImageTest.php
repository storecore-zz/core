<?php
class AMPImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store front AMP image class file exists
     */
    public function testStoreFrontAMPImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'Image.php'
        );
    }

    /**
     * @group distro
     * @testdox Implemented LayoutInterface interface file exists
     */
    public function testImplementedLayoutInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'LayoutInterface.php'
        );
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Image');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Image');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\Image', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns <amp-img> tag
     */
    public function testPublicToStringMethodIsPublicReturnsAmpImgTag()
    {
        $img = new \StoreCore\StoreFront\AMP\Image();
        $this->assertStringStartsWith('<amp-img ', (string)$img);
    }

    /**
     * @testdox Public __toString() method returns layout="responsive" attribute by default
     */
    public function testPublicToStringMethodIsPublicReturnsLayoutIsResponsiveAttributeByDefault()
    {
        $img = new \StoreCore\StoreFront\AMP\Image();
        $this->assertContains(' layout="responsive"', (string)$img);
    }

    /**
     * @testdox Public getLayout() method exists
     */
    public function testPublicGetLayoutMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Image');
        $this->assertTrue($class->hasMethod('getLayout'));
    }

    /**
     * @testdox Public getLayout() method is public
     */
    public function testPublicGetLayoutMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\Image', 'getLayout');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getLayout() method returns 'responsive' by default
     */
    public function testPublicGetLayoutMethodReturnsResponsiveByDefault()
    {
        $image = new \StoreCore\StoreFront\AMP\Image();
        $this->assertEquals('responsive', $image->getLayout());
    }

    /**
     * @testdox Public setFallback() method exists
     */
    public function testPublicSetFallbackMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Image');
        $this->assertTrue($class->hasMethod('setFallback'));
    }

    /**
     * @testdox Public setFallback() method is public
     */
    public function testPublicSetFallbackMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\Image', 'setFallback');
        $this->assertTrue($method->isPublic());
    }
}
