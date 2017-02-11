<?php
/**
 * @group hmvc
 */
class RedirectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreRedirectorClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Redirector.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Redirector');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    public function testFindMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Redirector', 'find');
        $this->assertTrue($method->isPublic());
    }

    public function testFindMethodIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Redirector', 'find');
        $this->assertTrue($method->isStatic());
    }
}
