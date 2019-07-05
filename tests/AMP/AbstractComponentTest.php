<?php
class AbstractComponentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox AMP AbstractComponent class file exists
     */
    public function testAmpAbstractComponentClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'AbstractComponent.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP AbstractComponent class is abstract
     */
    public function testAmpAbstractComponentClassIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AbstractComponent');
        $this->assertTrue($class->isAbstract());
    }

    /**
     * @group distro
     * @testdox Implemented AMP LayoutInterface interface file exists
     */
    public function testImplementedAmpLayoutInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'LayoutInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox AMP AbstractComponent implements AMP LayoutInterface
     */
    public function testAmpAbstractComponentImplementsAmpLayoutInterface()
    {
        $stub = $this->getMockForAbstractClass('\StoreCore\AMP\AbstractComponent');
        $this->assertInstanceOf('\StoreCore\AMP\LayoutInterface', $stub);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AbstractComponent');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\AMP\AbstractComponent::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\AbstractComponent::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant matches master branch
     */
    public function testVersionConstantMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\AbstractComponent::VERSION);
    }


    /**
     * @testdox AbstractComponent class has Attributes property
     */
    public function testAbstractComponentClassHasAttributesProperty()
    {
        $this->assertClassHasAttribute('Attributes', \StoreCore\AMP\AbstractComponent::class);
    }

    /**
     * @depends testAbstractComponentClassHasAttributesProperty
     * @testdox Attributes property is protected
     */
    public function testAttributesPropertyIsProtected()
    {
        $property = new \ReflectionProperty(\StoreCore\AMP\AbstractComponent::class, 'Attributes');
        $this->assertTrue($property->isProtected());
    }


    /**
     * @testdox AbstractComponent class has SupportedLayouts property
     */
    public function testAbstractComponentClassHasSupportedLayoutsProperty()
    {
        $this->assertClassHasAttribute('SupportedLayouts', \StoreCore\AMP\AbstractComponent::class);
    }

    /**
     * @depends testAbstractComponentClassHasAttributesProperty
     * @testdox Attributes property is protected
     */
    public function testSupportedLayoutsPropertyIsProtected()
    {
        $property = new \ReflectionProperty(\StoreCore\AMP\AbstractComponent::class, 'SupportedLayouts');
        $this->assertTrue($property->isProtected());
    }


    /**
     * @testdox AbstractComponent::getLayout() exists
     */
    public function testAbstractComponentGetLayoutExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AbstractComponent');
        $this->assertTrue($class->hasMethod('getLayout'));
    }

    /**
     * @testdox AbstractComponent::getLayout() is public
     */
    public function testAbstractComponentGetLayoutIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'getLayout');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox AbstractComponent::getLayout() has no parameters
     */
    public function testAbstractComponentGetLayoutHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'getLayout');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox AbstractComponent::getLayout() returns non-empty string
     */
    public function testAbstractComponentGetLayoutReturnsNonEmptyString()
    {
        $mock = $this->getMockForAbstractClass('\StoreCore\AMP\AbstractComponent');
        $this->assertNotEmpty($mock->getLayout());
        $this->assertInternalType('string', $mock->getLayout());
    }

    /**
     * @depends testAbstractComponentGetLayoutReturnsNonEmptyString
     * @testdox AbstractComponent::getLayout() returns string "responsive" by default
     */
    public function testAbstractComponentGetLayoutReturnsStringResponsiveByDefault()
    {
        $mock = $this->getMockForAbstractClass('\StoreCore\AMP\AbstractComponent');
        $this->assertEquals('responsive', $mock->getLayout());
    }


    /**
     * @testdox AbstractComponent::insert() exists
     */
    public function testAbstractComponentInsertExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AbstractComponent');
        $this->assertTrue($class->hasMethod('insert'));
    }

    /**
     * @testdox AbstractComponent::insert() is public
     */
    public function testAbstractComponentInsertIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'insert');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox AbstractComponent::insert() has one required parameter
     */
    public function testAbstractComponentInsertHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'insert');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox AbstractComponent::setLayout() exists
     */
    public function testAbstractComponentSetLayoutExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\AbstractComponent');
        $this->assertTrue($class->hasMethod('setLayout'));
    }

    /**
     * @testdox AbstractComponent::setLayout() is public
     */
    public function testAbstractComponentSetLayoutIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'setLayout');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox AbstractComponent::setLayout() has one required parameter
     */
    public function testAbstractComponentSetLayoutHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\AbstractComponent', 'setLayout');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox AbstractComponent::setLayout() throws \InvalidArgumentException on empty string
     */
    public function testAbstractComponentSetLayoutThrowsInvalidArgumentExceptionOnEmptyString()
    {
        $empty_string = (string)null;
        $this->assertEmpty($empty_string);
        $mock = $this->getMockForAbstractClass('\StoreCore\AMP\AbstractComponent');
        $mock->setLayout($empty_string);
    }
}
