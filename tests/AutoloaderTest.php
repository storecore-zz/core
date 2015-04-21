<?php
class MockAutoloader extends \StoreCore\Autoloader
{
    protected $files = array();

    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    protected function requireFile($file)
    {
        return in_array($file, $this->files);
    }
}

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testCoreAutoloaderClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'Autoloader.php');
    }

    /**
     * @group distro
     */
    public function testCoreBootloaderFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT . 'bootloader.php');
    }

    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Autoloader');
        $this->assertTrue($class->hasConstant('VERSION'));
    }
}
