<?php
class AMPPlaceholderImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store front AMP placeholder image class file exists
     */
    public function testStoreFrontAMPPlaceholderImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'PlaceholderImage.php'
        );
    }

    /**
     * @group distro
     * @testdox Extended AMP image class file exists
     */
    public function testExtendedAMPImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'Image.php'
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
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\PlaceholderImage');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testPublicToStringMethodExists
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\PlaceholderImage', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns <amp-img> tag
     */
    public function testPublicToStringMethodIsPublicReturnsAmpImgTag()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertStringStartsWith('<amp-img ', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method returns </amp-img> closing tag
     */
    public function testPublicToStringMethodIsPublicReturnsAmpImgClosingTag()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertContains('</amp-img>', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method returns placeholder attribute by default
     */
    public function testPublicToStringMethodIsPublicReturnsPlaceholderAttribute()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertContains(' placeholder', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method returns layout="fill" attribute
     */
    public function testPublicToStringMethodIsPublicReturnsLayoutIsFillAttribute()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertContains(' layout="fill"', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method does not return alt attribute
     */
    public function testPublicToStringMethodDoesNotReturnAltAttribute()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertNotContains(' alt=', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method does not return height attribute
     */
    public function testPublicToStringMethodDoesNotReturnHeightAttribute()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertNotContains(' height=', (string)$placeholder_image);
    }

    /**
     * @testdox Public __toString() method does not return width attribute
     */
    public function testPublicToStringMethodDoesNotReturnWidthAttribute()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertNotContains(' width=', (string)$placeholder_image);
    }

    /**
     * @testdox Public getLayout() method returns 'fill' by default
     */
    public function testPublicGetLayoutMethodReturnsFillByDefault()
    {
        $placeholder_image = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertEquals('fill', $placeholder_image->getLayout());
    }
}
