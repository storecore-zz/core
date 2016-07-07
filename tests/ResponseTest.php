<?php
/**
 * @group hmvc
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreResponseClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Response.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Response');
        $this->assertTrue($class->hasConstant('VERSION'));

    }

    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Response::VERSION);
    }
}
