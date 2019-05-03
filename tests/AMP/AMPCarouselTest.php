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
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\Carousel::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\Carousel::VERSION);
    }

    /**
     * @depends testVersionConstantIsNotEmpty
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\Carousel::VERSION);
    }


    /**
     * @testdox Carousel has Autoplay property
     */
    public function testCarouselHasAutoplayProperty()
    {
        $this->assertClassHasAttribute('Autoplay', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setAutoplay() exists
     */
    public function testCarouselSetAutoplayExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setAutoplay'));
    }

    /**
     * @testdox Carousel::setAutoplay() is public
     */
    public function testCarouselSetAutoplayIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setAutoplay');
        $this->assertTrue($method->isPublic());
    }


    /**
     * @testdox Carousel has Children property
     */
    public function testCarouselHasChildrenProperty()
    {
        $this->assertClassHasAttribute('Children', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::appendChild() method exists
     */
    public function testCarouselAppendChildMethodExists()
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
     * @testdox Carousel has Delay property
     */
    public function testCarouselHasDelayProperty()
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
     * @testdox Carousel::setDelay() is public
     */
    public function testCarouselSetDelayIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setDelay');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Carousel::setDelay() has one required parameter
     */
    public function testCarouselSetDelayHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setDelay');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Carousel has Height property
     */
    public function testCarouselHasHeightProperty()
    {
        $this->assertClassHasAttribute('Height', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setHeight() exists
     */
    public function testCarouselSetHeightExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setHeight'));
    }

    /**
     * @testdox Carousel::setHeight() is public
     */
    public function testCarouselSetHeightIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setHeight');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Carousel::setHeight() has one required parameter
     */
    public function testCarouselSetHeightHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setHeight');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox Carousel has Type property
     */
    public function testCarouselHasTypeProperty()
    {
        $this->assertClassHasAttribute('Type', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setType() exists
     */
    public function testCarouselSetTypeExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setType'));
    }

    /**
     * @testdox Carousel::setType() is public
     */
    public function testCarouselSetTypeIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setType');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCarouselSetTypeExists
     * @testdox Carousel::setType() has one required parameter
     */
    public function testCarouselSetTypeHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setType');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Carousel::setType() throws \InvalidArgumentException on empty string
     */
    public function testCarouselSetTypeThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $carousel = new \StoreCore\AMP\Carousel();
        $this->assertEmpty($empty_string);
        $carousel->setType($empty_string);
    }


    /**
     * @testdox Carousel has Width property
     */
    public function testCarouselHasWidthProperty()
    {
        $this->assertClassHasAttribute('Width', '\StoreCore\AMP\Carousel');
    }

    /**
     * @testdox Carousel::setWidth() exists
     */
    public function testCarouselSetWidthExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\Carousel');
        $this->assertTrue($class->hasMethod('setWidth'));
    }

    /**
     * @depends testCarouselSetWidthExists
     * @testdox Carousel::setWidth() is public
     */
    public function testCarouselSetWidthIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setWidth');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCarouselSetWidthExists
     * @testdox Carousel::setWidth() has one required parameter
     */
    public function testCarouselSetWidthHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\Carousel', 'setWidth');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
