<?php
class StoreIDTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     * @testdox Core store ID class file exists
     */
    public function testCoreStoreIdClassFileExists()
    {
        $this->assertFileExists(\StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'StoreID.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\StoreID');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     */
    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\StoreID::VERSION);
    }

    /**
     * @group distro
     */
    public function testExtendedTinyintUnsignedClassFileExists()
    {
        $this->assertFileExists(\StoreCore\FileSystem\LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'TinyintUnsigned.php');
    }
}
