<?php
namespace StoreCore;

class View
{
    private $Data = array();
    private $Template;

    /**
     * @param null|string $template
     * @return void
     */
    public function __construct($template = null)
    {
        if ($template !== null) {
            $this->setTemplate($template);
        }
    }

    /**
     * @param string $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->Template = $template;
    }

    /**
     * @param array $values
     * @return void
     */
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            $this->Data[$name] = $value;
        }
    }

    /**
     * @param void
     * @return string
     */
    public function render()
    {
        if (count($this->Data) !== 0) {
            extract($this->Data);
        }

        ob_start();
        include $this->Template;
        return ob_get_clean();
    }
}
