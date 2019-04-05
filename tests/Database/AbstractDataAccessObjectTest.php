<?php
class AbstractDataAccessObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testAbstractDataAccessObjectClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Database/AbstractDataAccessObject.php');
    }

    /**
     * @group hmvc
     */
    public function testAbstractDataAccessObjectIsAbstract()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->isAbstract());
    }

    /**
     * @group hmvc
     */
    public function testAbstractDataAccessObjectIsAAbstractDatabaseModel()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->isSubclassOf('\StoreCore\Database\AbstractModel'));
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Database\AbstractDataAccessObject::VERSION);
        $this->assertInternalType('string', \StoreCore\Database\AbstractDataAccessObject::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('1.0.0', \StoreCore\Database\AbstractDataAccessObject::VERSION);
    }


    /**
     * @group distro
     * @testdox Public create() method exists
     */
    public function testPublicCreateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->hasMethod('create'));
    }

    /**
     * @testdox Public create() method is public
     */
    public function testPublicCreateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'create');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public create() method has one required parameter
     */
    public function testPublicCreateMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'create');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @group distro
     * @testdox Public read() method exists
     */
    public function testPublicReadMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->hasMethod('read'));
    }

    /**
     * @testdox Public read() method is public
     */
    public function testPublicReadMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'read');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public read() method has two parameters
     */
    public function testPublicReadMethodHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'read');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @testdox Public read() method has one required parameter
     */
    public function testPublicReadMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'read');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @group distro
     * @testdox Public update() method exists
     */
    public function testPublicUpdateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->hasMethod('update'));
    }

    /**
     * @testdox Public update() method is public
     */
    public function testPublicUpdateMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'update');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public update() method has two parameters
     */
    public function testPublicUpdateMethodHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'update');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @testdox Public update() method has one required parameter
     */
    public function testPublicUpdateMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'update');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }


    /**
     * @group distro
     * @testdox Public delete() method exists
     */
    public function testPublicDeleteMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Database\AbstractDataAccessObject');
        $this->assertTrue($class->hasMethod('delete'));
    }

    /**
     * @testdox Public delete() method is public
     */
    public function testPublicDeleteMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'delete');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public delete() method has two parameters
     */
    public function testPublicDeleteMethodHasTwoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'delete');
        $this->assertTrue($method->getNumberOfParameters() === 2);
    }

    /**
     * @testdox Public delete() method has one required parameter
     */
    public function testPublicDeleteMethodHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Database\AbstractDataAccessObject', 'delete');
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }
}
