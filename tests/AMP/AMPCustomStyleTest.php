<?php
class AMPCustomStyleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox CustomStyle class file exists
     */
    public function testCustomStyleClassFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AMP' . DIRECTORY_SEPARATOR . 'CustomStyle.php'
        );
    }


    /**
     * @group distro
     * @testdox Implemented \StoreCore\Types\StringableInterface interface file exists
     */
    public function testImplementedStoreCoreTypesStringableInterfaceInterfaceFileExists()
    {
        $this->assertFileExists(
            STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR . 'StringableInterface.php'
        );
    }

    /**
     * @group hmvc
     * @testdox CustomStyle implements \StoreCore\Types\StringableInterface
     */
    public function testCustomStyleImplementsStoreCoreTypesStringableInterface()
    {
        $object = new \StoreCore\AMP\CustomStyle();
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }
    

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\CustomStyle');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\AMP\CustomStyle::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertInternalType('string', \StoreCore\AMP\CustomStyle::VERSION);
    }

    /**
     * @depends testVersionConstantIsNotEmpty
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\AMP\CustomStyle::VERSION);
    }


    /**
     * @group hmvc
     * @testdox CustomStyle::__toString() exists
     */
    public function testCustomStyleToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\CustomStyle');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @depends testCustomStyleToStringExists
     * @group hmvc
     * @testdox CustomStyle::__toString() returns non-empty string
     */
    public function testCustomStyleToStringReturnsNonEmptyString()
    {
        $object = new \StoreCore\AMP\CustomStyle();
        $html = (string)$object;
        $this->assertNotEmpty($html);
        $this->assertInternalType('string', $html);
    }

    /**
     * @depends testCustomStyleToStringReturnsNonEmptyString
     * @group hmvc
     * @testdox CustomStyle::__toString() returns <style amp-custom> tag
     */
    public function testCustomStyleToStringReturnsStyleAmpCustomTag()
    {
        $object = new \StoreCore\AMP\CustomStyle();
        $html = (string)$object;
        $this->assertStringStartsWith('<style amp-custom>', $html);
        $this->assertStringEndsWith('</style>', $html);
    }


    /**
     * @testdox CustomStyle::append() exists
     */
    public function testCustomStyleAppendExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\CustomStyle');
        $this->assertTrue($class->hasMethod('append'));
    }

    /**
     * @depends testCustomStyleAppendExists
     * @testdox CustomStyle::append() is public
     */
    public function testCustomStyleAppendIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'append');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCustomStyleAppendExists
     * @testdox CustomStyle::append() has one required parameter
     */
    public function testCustomStyleAppendHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'append');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @testdox CustomStyle::getRoot() exists
     */
    public function testCustomStyleGetRootExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\CustomStyle');
        $this->assertTrue($class->hasMethod('getRoot'));
    }

    /**
     * @depends testCustomStyleGetRootExists
     * @testdox CustomStyle::getRoot() is public
     */
    public function testCustomStyleGetRootIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'getRoot');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCustomStyleGetRootExists
     * @testdox CustomStyle::getRoot() has no parameters
     */
    public function testCustomStyleGetRootHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'getRoot');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testCustomStyleGetRootHasNoParameters
     * @group hmvc
     * @testdox CustomStyle::getRoot() returns non-empty string
     */
    public function testCustomStyleGetRootReturnsNonEmptyString()
    {
        $object = new \StoreCore\AMP\CustomStyle();
        $html = $object->getRoot();
        $this->assertNotEmpty($html);
        $this->assertInternalType('string', $html);
    }

    /**
     * @depends testCustomStyleGetRootReturnsNonEmptyString
     * @group hmvc
     * @testdox CustomStyle::getRoot() returns CSS :root{…} element
     */
    public function testCustomStyleGetRootReturnsCssRootElement()
    {
        $object = new \StoreCore\AMP\CustomStyle();
        $html = $object->getRoot();
        $this->assertStringStartsWith(':root{', $html);
        $this->assertStringEndsWith('}', $html);
    }


    /**
     * @testdox CustomStyle::set() exists
     */
    public function testCustomStyleSetExists()
    {
        $class = new \ReflectionClass('\StoreCore\AMP\CustomStyle');
        $this->assertTrue($class->hasMethod('set'));
    }

    /**
     * @depends testCustomStyleSetExists
     * @testdox CustomStyle::set() is public
     */
    public function testCustomStyleSetIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'set');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testCustomStyleSetExists
     * @testdox CustomStyle::set() has two required parameters
     */
    public function testCustomStyleSetHasTwoRequiredParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\AMP\CustomStyle', 'set');
        $this->assertTrue($method->getNumberOfParameters() === 2);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 2);
    }
}
