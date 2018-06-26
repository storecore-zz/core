<?php
class AMPFallbackImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP fallback image class file exists
     */
    public function testAMPImageFallbackClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'FallbackImage.php'
        );
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\FallbackImage');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\PlaceholderImage');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\FallbackImage', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns <amp-img> tag
     */
    public function testPublicToStringMethodIsPublicReturnsAmpImgTag()
    {
        $image = new \StoreCore\AMP\FallbackImage();
        $this->assertStringStartsWith('<amp-img ', (string)$image);
    }

    /**
     * @testdox Public __toString() method returns placeholder attribute by default
     */
    public function testPublicToStringMethodIsPublicReturnsFallbackAttribute()
    {
        $image = new \StoreCore\AMP\FallbackImage();
        $this->assertContains(' fallback', (string)$image);
    }
}
