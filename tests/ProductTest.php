<?php
class ProductTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testProductClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Product.php');
    }

    /**
     * @group distro
     * @testdox Extended \StoreCore\AbstractModel class file exists
     */
    public function testExtendedStoreCoreAbstractModelClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'AbstractModel.php');
    }

    /**
     * @group hmvc
     * @testdox Product extends \StoreCore\AbstractModel
     */
    public function testProductExtendsStoreCoreAbstractModel()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\AbstractModel', $product);
    }

    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is not empty
     */
    public function testVersionConstantIsNotEmpty()
    {
        $this->assertNotEmpty(\StoreCore\Product::VERSION);
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is string
     */
    public function testVersionConstantIsString()
    {
        $this->assertTrue(is_string(\StoreCore\Product::VERSION));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Product::VERSION);
    }


    /**
     * @testdox Public setAvailability() method exists
     */
    public function publicSetAvailabilityMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setAvailability'));
    }

    /**
     * @depends publicSetAvailabilityMethodExists
     * @testdox Public setAvailability() method is public
     */
    public function publicSetAvailabilityMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setAvailability');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends publicSetAvailabilityMethodExists
     * @testdox Public setAvailability() method has only one required parameter
     */
    public function testPublicSetAvailabilityMethodHasOnlyOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setAvailability');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @depends testPublicSetAvailabilityMethodHasOnlyOneRequiredParameter
     * @expectedException \ErrorException
     * @testdox Public setAvailability() method requires \StoreCore\Types\ItemAvailability object
     */
    public function testPublicSetAvailabilityMethodRequiresStoreCoreTypesItemAvailabilityObject()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setAvailability(true);
    }

    /**
     * @testdox Public getAvailability() method exists
     */
    public function testPublicGetAvailabilityMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getAvailability'));
    }

    /**
     * @depends testPublicGetAvailabilityMethodExists
     * @testdox Public getAvailability() method is public
     */
    public function testPublicGetAvailabilityMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getAvailability');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetAvailabilityMethodExists
     * @testdox Public getAvailability() method has no parameters
     */
    public function testPublicGetAvailabilityMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getAvailability');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetAvailabilityMethodExists
     * @group hmvc
     * @testdox Public getAvailability() method returns \StoreCore\Types\ItemAvailability object
     */
    public function testPublicGetAvailabilityMethodReturnsStoreCoreTypesItemAvailabilityObject()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertInstanceOf('\StoreCore\Types\ItemAvailability', $product->getAvailability());
    }


    /**
     * @testdox Public getIntroductionDate() method exists
     */
    public function publicGetIntroductionDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getIntroductionDate'));
    }

    /**
     * @depends publicGetIntroductionDateMethodExists
     * @testdox Public getIntroductionDate() method is public
     */
    public function testPublicGetIntroductionDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getIntroductionDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetIntroductionDateMethodIsPublic
     * @testdox Public getIntroductionDate() method has no parameters
     */
    public function testPublicGetIntroductionDateMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getIntroductionDate');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetIntroductionDateMethodIsPublic
     * @testdox Public getIntroductionDate() method returns null by default
     */
    public function testPublicGetIntroductionDateMethodReturnsNullByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertNull($product->getIntroductionDate());
    }


    /**
     * @testdox Public setModificationDate() method exists
     */
    public function publicSetModificationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setModificationDate'));
    }

    /**
     * @depends publicSetModificationDateMethodExists
     * @testdox Public setModificationDate() method is public
     */
    public function publicSetModificationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setModificationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends publicSetModificationDateMethodExists
     * @testdox Public setModificationDate() method has one parameter
     */
    public function testPublicSetModificationDateMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setModificationDate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @depends testPublicSetModificationDateMethodHasOneParameter
     * @testdox Public setModificationDate() method accepts DateTime object
     */
    public function testPublicSetModificationDateMethodAcceptsDateTimeObject()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->assertTrue($now instanceof \DateTime);
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setModificationDate($now);
        $this->assertEquals($now, $product->getModificationDate());
    }

    /**
     * @depends testPublicSetModificationDateMethodHasOneParameter
     * @testdox Public setModificationDate() method accepts date/time string
     */
    public function testPublicSetModificationDateMethodAcceptsDateTimeString()
    {
        $string = '2018-04-01 22:21:20';
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $string);

        $product_str = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product_str->setModificationDate($string);

        $product_dtm = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product_dtm->setModificationDate($datetime);

        $this->assertEquals($product_str, $product_dtm);
        $this->assertEquals($product_str->getModificationDate(), $product_dtm->getModificationDate());
    }

    /**
     * @testdox Public getModificationDate() method exists
     */
    public function publicGetModificationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getModificationDate'));
    }

    /**
     * @depends publicGetModificationDateMethodExists
     * @testdox Public getModificationDate() method is public
     */
    public function testPublicGetModificationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getModificationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetModificationDateMethodIsPublic
     * @testdox Public getModificationDate() method has no parameters
     */
    public function testPublicGetModificationDateMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getModificationDate');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetModificationDateMethodIsPublic
     * @testdox Public getModificationDate() method returns DateTime object by default
     */
    public function testPublicGetModificationDateMethodReturnsDateTimeObjectByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertTrue($product->getModificationDate() instanceof \DateTime);
    }


    /**
     * @testdox Public setParentID() method exists
     */
    public function testPublicSetParentIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setParentID'));
    }

    /**
     * @depends testPublicSetParentIdMethodExists
     * @testdox Public setParentID() method is public
     */
    public function testPublicSetParentIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setParentID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicSetParentIdMethodExists
     * @testdox Public setParentID() method has one parameter
     */
    public function testPublicSetParentIdMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setParentID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @testdox Public getParentID() method exists
     */
    public function testPublicGetParentIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getParentID'));
    }

    /**
     * @depends testPublicGetParentIdMethodExists
     * @testdox Public getParentID() method is public
     */
    public function testPublicGetParentIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getParentID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetParentIdMethodExists
     * @testdox Public getParentID() method has no parameters
     */
    public function testPublicGetParentIdMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getParentID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetParentIdMethodExists
     * @testdox Public getParentID() method returns null by default
     */
    public function testPublicGetParentIdMethodReturnsNullByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertTrue($product->getParentID() === null);
    }

    /**
     * @depends testPublicGetParentIdMethodExists
     * @depends testPublicSetParentIdMethodExists
     * @testdox public getParentID() method returns set ProductID object
     */
    public function testPublicGetParentIdMethodReturnsSetParentIdObject()
    {
        $unsigned_mediumint_maximum = 16777215;
        $parent_product_id = new \StoreCore\Types\ProductID($unsigned_mediumint_maximum);
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setParentID($parent_product_id);
        $this->assertSame($parent_product_id, $product->getParentID());
    }


    /**
     * @testdox Public setProductID() method exists
     */
    public function publicSetProductIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setProductID'));
    }

    /**
     * @depends publicSetProductIdMethodExists
     * @testdox Public setProductID() method is public
     */
    public function publicSetProductIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setProductID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends publicSetProductIdMethodExists
     * @testdox Public setProductID() method has one parameter
     */
    public function testPublicSetProductIdMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setProductID');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @testdox Public setProductID() method throws \InvalidArgumentException on alphanumeric string
     */
    public function testPublicSetProductIdMethodThrowsInvalidArgumentExceptionOnAlphanumericString()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setProductID('1234ab');
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setProductID() method throws \DomainException on -1 (minus one)
     */
    public function testPublicSetProductIdMethodThrowsDomainExceptionOnMinusOne()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setProductID(-1);
    }

    /**
     * @expectedException \DomainException
     * @testdox Public setProductID() method throws \DomainException on 0 (zero)
     */
    public function testPublicSetProductIdMethodThrowsDomainExceptionOnZero()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setProductID(0);
    }

    /**
     * @testdox Public setProductID() method accepts integers
     */
    public function testPublicSetProductIdMethodAcceptsIntegers()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $integers = array(144, 233, 377, 610, 987, 1597, 2584, 4181, 6765, 10946);
        foreach ($integers as $integer) {
            $product->setProductID($integer);
            $product_id = $product->getProductID();
            $product_id = (string)$product_id;
            $this->assertEquals($integer, $product_id);
        }
    }

    /**
     * @testdox Public setProductID() accepts integers as strings
     */
    public function testPublicSetProductIdMethodAcceptsIntegersAsStrings()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $numbers = array('144', '233', '377', '610', '987', '1597', '2584', '4181', '6765', '10946');
        foreach ($numbers as $number) {
            $product->setProductID($number);
            $product_id = $product->getProductID();
            $product_id = (string)$product_id;
            $this->assertSame($number, $product_id);
        }
    }

    /**
     * @testdox Public getProductID() method exists
     */
    public function testPublicGetProductIdMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getProductID'));
    }

    /**
     * @depends testPublicGetProductIdMethodExists
     * @testdox Public getProductID() method is public
     */
    public function testPublicGetProductIdMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getProductID');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetProductIdMethodExists
     * @testdox Public getProductID() method has no parameters
     */
    public function testPublicGetProductIdMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getProductID');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetProductIdMethodExists
     * @testdox Public getProductID() method returns null by default
     */
    public function testPublicGetProductIdMethodReturnsNullByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertTrue($product->getProductID() === null);
    }

    /**
     * @testdox public getProductID method returns set ProductID object
     */
    public function testPublicGetProductIdMethodReturnsSetProductIdObject()
    {
        $unsigned_mediumint_maximum = 16777215;
        $product_id = new \StoreCore\Types\ProductID($unsigned_mediumint_maximum);
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $product->setProductID($product_id);
        $this->assertSame($product_id, $product->getProductID());
    }


    /**
     * @testdox Public setSalesDiscontinuationDate() method exists
     */
    public function testPublicSetSalesDiscontinuationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setSalesDiscontinuationDate'));
    }

    /**
     * @depends testPublicSetSalesDiscontinuationDateMethodExists
     * @testdox Public setSalesDiscontinuationDate() method is public
     */
    public function testPublicSetSalesDiscontinuationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setSalesDiscontinuationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicSetSalesDiscontinuationDateMethodExists
     * @testdox Public setSalesDiscontinuationDate() method has one parameter
     */
    public function testPublicSetSalesDiscontinuationDateMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setSalesDiscontinuationDate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @testdox Public getSalesDiscontinuationDate() method exists
     */
    public function testPublicGetSalesDiscontinuationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getSalesDiscontinuationDate'));
    }

    /**
     * @depends testPublicGetSalesDiscontinuationDateMethodExists
     * @testdox Public getSalesDiscontinuationDate() method is public
     */
    public function testPublicGetSalesDiscontinuationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getSalesDiscontinuationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetSalesDiscontinuationDateMethodIsPublic
     * @testdox Public getSalesDiscontinuationDate() method has no parameters
     */
    public function testPublicGetSalesDiscontinuationDateMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getSalesDiscontinuationDate');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetSalesDiscontinuationDateMethodIsPublic
     * @testdox Public getSalesDiscontinuationDate() method returns null by default
     */
    public function testPublicGetSalesDiscontinuationDateMethodReturnsNullByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertNull($product->getSalesDiscontinuationDate());
    }


    /**
     * @testdox Public setSupportDiscontinuationDate() method exists
     */
    public function testPublicSetSupportDiscontinuationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('setSupportDiscontinuationDate'));
    }

    /**
     * @depends testPublicSetSupportDiscontinuationDateMethodExists
     * @testdox Public setSupportDiscontinuationDate() method is public
     */
    public function testPublicSetSupportDiscontinuationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setSupportDiscontinuationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicSetSupportDiscontinuationDateMethodExists
     * @testdox Public setSupportDiscontinuationDate() method has one parameter
     */
    public function testPublicSetSupportDiscontinuationDateMethodHasOneParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'setSupportDiscontinuationDate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
    }

    /**
     * @testdox Public getSupportDiscontinuationDate() method exists
     */
    public function testPublicGetSupportDiscontinuationDateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('getSupportDiscontinuationDate'));
    }

    /**
     * @depends testPublicGetSupportDiscontinuationDateMethodExists
     * @testdox Public getSupportDiscontinuationDate() method is public
     */
    public function testPublicGetSupportDiscontinuationDateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getSupportDiscontinuationDate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicGetSupportDiscontinuationDateMethodExists
     * @testdox Public getSupportDiscontinuationDate() method has no parameters
     */
    public function testPublicGetSupportDiscontinuationDateMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'getSupportDiscontinuationDate');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicGetSupportDiscontinuationDateMethodExists
     * @testdox Public getSupportDiscontinuationDate() method returns null by default
     */
    public function testPublicGetSupportDiscontinuationDateMethodReturnsNullByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertNull($product->getSupportDiscontinuationDate());
    }


    /**
     * @testdox Public isService() method exists
     */
    public function testPublicIsServiceMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Product');
        $this->assertTrue($class->hasMethod('isService'));
    }

    /**
     * @depends testPublicIsServiceMethodExists
     * @testdox Public isService() method is public
     */
    public function testPublicIsServiceMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'isService');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @depends testPublicIsServiceMethodExists
     * @testdox Public isService() method has no parameters
     */
    public function testPublicIsServiceMethodHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Product', 'isService');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @depends testPublicIsServiceMethodExists
     * @testdox Public isService() method returns false by default
     */
    public function testPublicIsServiceMethodReturnsFalseByDefault()
    {
        $product = new \StoreCore\Product(\StoreCore\Registry::getInstance());
        $this->assertFalse($product->isService());
    }
}
