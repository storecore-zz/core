<?php
class AMPPlaceholderImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store front AMP placeholder image class file exists
     */
    public function testStoreFrontAMPImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'PlaceholderImage.php'
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
        $img = new \StoreCore\StoreFront\AMP\Image();
        $this->assertContains('<amp-img ', (string)$img);
    }

    /**
     * @testdox Public __toString() method returns placeholder attribute by default
     */
    public function testPublicToStringMethodIsPublicReturnsPlaceholderAttribute()
    {
        $img = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertContains(' placeholder', (string)$img);
    }

    /**
     * @testdox Public __toString() method returns layout="fill" attribute
     */
    public function testPublicToStringMethodIsPublicReturnsLayoutIsFillAttribute()
    {
        $img = new \StoreCore\StoreFront\AMP\PlaceholderImage();
        $this->assertContains(' layout="fill"', (string)$img);
    }
}
