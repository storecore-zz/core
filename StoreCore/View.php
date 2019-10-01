<?php
namespace StoreCore;

/**
 * MVC View
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class View
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '1.0.0';

    /**
     * @var array $Data
     *   Array containing the names and values of PHP variables to include in
     *   the MVC view.
     */
    protected $Data = array();

    /**
     * @var string|null $Template
     *   File name of a template to include in the view.
     */
    protected $Template;

    /**
     * Construct an MVC view.
     *
     * @param null|string $template
     *   Optional template to include in the view.
     *
     * @return self
     *
     * @uses setTemplate()
     */
    public function __construct($template = null)
    {
        if ($template !== null) {
            $this->setTemplate($template);
        }
    }

    /**
     * Set the template for the view.
     *
     * @param string $template
     *   Name of the template file to include.  The file name may contain
     *   a full or partial local path.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws a Standard PHP Library (SPL) invalid argument logic exception
     *   if the `$template` parameter is not a string or empty.  This method
     *   does not validate if the template file actually exists nor if the file
     *   is readable.
     */
    public function setTemplate($template)
    {
        if (!is_string($template) || empty($template)) {
            throw new \InvalidArgumentException();
        }
        $this->Template = $template;
    }

    /**
     * Add variable values to the view.
     *
     * @param array $values
     *   Flat array containing the name and the value of one or more variables
     *   to include in the view.
     *
     * @return void
     */
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            $this->Data[$name] = $value;
        }
    }

    /**
     * Render the view.
     *
     * @param void
     *
     * @return string
     *   Returns a string with the parsed template and values.  In most cases
     *   the returned string is an HTML fragment.
     */
    public function render()
    {
        if ($this->Data !== null) {
            extract($this->Data);
        }

        ob_start();
        include $this->Template;
        return ob_get_clean();
    }
}
