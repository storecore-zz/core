<?php
namespace StoreCore;

/**
 * MVC View
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class View
{
    const VERSION = '0.1.0';

    /**
     * @var array|null $Data
     * @var string|null $Template
     */
    private $Data = array();
    private $Template;

    /**
     * @param null|string $template
     * @return $this
     */
    public function __construct($template = null)
    {
        if ($template !== null) {
            $this->setTemplate($template);
        }
        return $this;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->Template = $template;
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            $this->Data[$name] = $value;
        }
        return $this;
    }

    /**
     * @param void
     * @return string
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
