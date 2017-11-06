<?php
class AMPCarouselTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Store front AMP carousel class file exists
     */
    public function testStoreFrontAMPCarouselClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'StoreFront' . DIRECTORY_SEPARATOR . 'AMP' . DIRECTORY_SEPARATOR . 'Carousel.php'
        );
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Carousel');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox REQUIRED_SCRIPT constant is defined
     */
    public function testRequiredScriptConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Carousel');
        $this->assertTrue($class->hasConstant('REQUIRED_SCRIPT'));
    }
}
