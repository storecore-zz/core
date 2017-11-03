<?php
class AMPFallbackImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store front AMP fallback image class file exists
     */
    public function testStoreFrontAMPImageFallbackClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'FallbackImage.php'
        );
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\FallbackImage');
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
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\FallbackImage', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns <amp-img> tag
     */
    public function testPublicToStringMethodIsPublicReturnsAmpImgTag()
    {
        $image = new \StoreCore\StoreFront\AMP\FallbackImage();
        $this->assertStringStartsWith('<amp-img ', (string)$image);
    }

    /**
     * @testdox Public __toString() method returns placeholder attribute by default
     */
    public function testPublicToStringMethodIsPublicReturnsFallbackAttribute()
    {
        $image = new \StoreCore\StoreFront\AMP\FallbackImage();
        $this->assertContains(' fallback', (string)$image);
    }
}
