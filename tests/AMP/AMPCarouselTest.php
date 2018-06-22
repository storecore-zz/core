<?php
class AMPCarouselTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP carousel class file exists
     */
    public function testAMPCarouselClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'Carousel.php'
        );
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @testdox REQUIRED_SCRIPT constant is defined
     */
    public function testRequiredScriptConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasConstant('REQUIRED_SCRIPT'));
    }

    /**
     * @testdox Class has Autoplay property
     */
    public function testClassHasAutoplayProperty()
    {
        $this->assertClassHasAttribute('Autoplay', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setAutoplay() method exists
     */
    public function testPublicSetAutoplayMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setAutoplay'));
    }

    /**
     * @testdox Public setAutoplay() method is public
     */
    public function testPublicSetAutoplayMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setAutoplay');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Class has Children property
     */
    public function testClassHasChildrenProperty()
    {
        $this->assertClassHasAttribute('Children', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public appendChild() method exists
     */
    public function testPublicAppendChildMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('appendChild'));
    }

    /**
     * @testdox Public appendChild() method is public
     */
    public function testPublicAppendChildMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'appendChild');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public appendChild() method returns node count
     */
    public function testPublicAppendChildMethodReturnsNodeCount()
    {
        $child_node = '<div>...</div>';
        $carousel = new \StoreCore\AMP\Carousel();
        $this->assertEquals(1, $carousel->appendChild($child_node));
        $this->assertEquals(2, $carousel->appendChild($child_node));
        $this->assertEquals(3, $carousel->appendChild($child_node));
    }

    /**
     * @testdox Class has Delay property
     */
    public function testClassHasDelayProperty()
    {
        $this->assertClassHasAttribute('Delay', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setDelay() method exists
     */
    public function testPublicSetDelayMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setDelay'));
    }

    /**
     * @testdox Public setDelay() method is public
     */
    public function testPublicSetDelayMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setDelay');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Class has Height property
     */
    public function testClassHasHeightProperty()
    {
        $this->assertClassHasAttribute('Height', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setHeight() method exists
     */
    public function testPublicSetHeightMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setHeight'));
    }

    /**
     * @testdox Public setHeight() method is public
     */
    public function testPublicSetHeightMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setHeight');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Class has Type property
     */
    public function testClassHasTypeProperty()
    {
        $this->assertClassHasAttribute('Type', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setType() method exists
     */
    public function testPublicSetTypeMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setType'));
    }

    /**
     * @testdox Public setType() method is public
     */
    public function testPublicSetTypeMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setType');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Public setType() method throws \InvalidArgumentException on empty string
     */
    public function testPublicSetTypeMethodThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $carousel = new \StoreCore\AMP\Carousel();
        $this->assertEmpty($empty_string);
        $carousel->setType($empty_string);
    }

    /**
     * @testdox Class has Width property
     */
    public function testClassHasWidthProperty()
    {
        $this->assertClassHasAttribute('Width', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Public setWidth() method exists
     */
    public function testPublicSetWidthMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setWidth'));
    }

    /**
     * @testdox Public setWidth() method is public
     */
    public function testPublicSetWidthMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setWidth');
        $this->assertTrue($method->isPublic());
    }
}
