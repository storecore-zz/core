<?php
namespace StoreCore;

/**
 * PSR-4 Compliant Framework Autoloader
 *
 * This autoloading class links a PHP namespace to a directory or multiple
 * directories.  Linking a 'Foo\Bar' namespace to its base directories looks
 * something like:
 *
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2014-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @see       https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 * @version   0.1.0
 */
class Autoloader
{
    const VERSION = '0.1.0';

    /**
     * @var array $Prefixes
     *   An associative array where the key is a namespace prefix and the
     *   value is an array of base directories for classes in that namespace.
     */
    protected $Prefixes = array();

    /**
     * Add a base directory for a namespace prefix.
     *
     * @param string $prefix
     *   The namespace prefix.
     *
     * @param string $base_dir
     *   A base directory for class files in the namespace.
     *
     * @param bool $prepend
     *   If true, prepend the base directory to the stack instead of
     *   appending it; this causes it to be searched first rather than last.
     *
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // Normalize namespace prefix
        $prefix = trim($prefix, '\\') . '\\';

        // Normalize the base directory with a trailing separator
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        // Initialize the namespace prefix array
        if (isset($this->Prefixes[$prefix]) === false) {
            $this->Prefixes[$prefix] = array();
        }

        // Retain the base directory for the namespace prefix
        if ($prepend) {
            array_unshift($this->Prefixes[$prefix], $base_dir);
        } else {
            array_push($this->Prefixes[$prefix], $base_dir);
        }
    }

    /**
     * Load the class file for a given class name.
     *
     * @param string $class
     *   The fully-qualified class name (FQCN).
     *
     * @return string|bool
     *   The mapped file name on success, or boolean false on failure.
     */
    public function loadClass($class)
    {
        // Current namespace prefix
        $prefix = $class;

        // Work backwards through the namespace names of the fully-qualified
        // class name to find a mapped file name.
        while (false !== $pos = strrpos($prefix, '\\')) {

            // retain the trailing namespace separator in the prefix
            $prefix = substr($class, 0, $pos + 1);

            // The rest is the relative class name
            $relative_class = substr($class, $pos + 1);

            // Try to load a mapped file for the prefix and relative class
            $mapped_file = $this->loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }

            // Remove the trailing namespace separator for the next iteration
            // of strrpos().
            $prefix = rtrim($prefix, '\\');
        }

        // Never found a mapped file
        return false;
    }

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $prefix
     *   The namespace prefix.
     *
     * @param string $relative_class
     *   The relative class name.
     *
     * @return bool|string
     *   Boolean false if no mapped file can be loaded, or the name of the
     *   mapped file that was loaded.
     */
    protected function loadMappedFile($prefix, $relative_class)
    {
        // Are there any base directories for this namespace prefix?
        if (isset($this->Prefixes[$prefix]) === false) {
            return false;
        }

        // Look through base directories for this namespace prefix
        foreach ($this->Prefixes[$prefix] as $base_dir) {

            // Replace the namespace prefix with the base directory,
            // replace namespace separators with directory separators
            // in the relative class name, and append with .php.
            $file = $base_dir
                . str_replace('\\', '/', $relative_class)
                . '.php';

            // If the mapped file exists, require it.
            if ($this->requireFile($file)) {
                return $file;
            }
        }

        // Never found it
        return false;
    }

    /**
     * Register loader with SPL autoloader stack.
     *
     * @param void
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'), true, true);
    }

    /**
     * If a file exists, require it from the file system.
     *
     * @param string $file
     *   The file to require.
     *
     * @return bool
     *   True if the file exists, false if not.
     */
    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
