<?php
class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testStoreFrontImageClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'Image.php'
        );
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\Image');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\Image');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method is public
     */
    public function testPublicToStringMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\Image', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public setAlt() method exists
     */
    public function testPublicSetAltMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\Image');
        $this->assertTrue($class->hasMethod('setAlt'));
    }

    /**
     * @testdox Public setAlt() method is public
     */
    public function testPublicSetAltMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\Image', 'setAlt');
        $this->assertTrue($method->isPublic());
    }
}
