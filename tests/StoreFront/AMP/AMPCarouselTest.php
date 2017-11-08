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

    /**
     * @testdox Class has Type property
     */
    public function testClassHasTypeProperty()
    {
        $this->assertClassHasAttribute('Type', '\StoreCore\StoreFront\AMP\Carousel');
    }

    /**
     * @testdox Public setType() method exists
     */
    public function testPublicSetTypeMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\StoreFront\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setType'));
    }

    /**
     * @testdox Public setType() method is public
     */
    public function testPublicSetTypeMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\StoreFront\AMP\Carousel', 'setType');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Public setType() method throws \InvalidArgumentException on empty string
     */
    public function testPublicSetTypeMethodThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $carousel = new \StoreCore\StoreFront\AMP\Carousel();
        $this->assertEmpty($empty_string);
        $carousel->setType($empty_string);
    }
}
