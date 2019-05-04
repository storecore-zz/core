<?php
namespace StoreCore\AMP;

/**
 * Abstract AMP Component
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/reference/components
 * @version   0.1.0
 */
abstract class AbstractComponent implements LayoutInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @param array $Attributes
     *   HTML5 and AMP HTML attributes of the component.
     */
    protected $Attributes = array(
        'layout' => LayoutInterface::LAYOUT_RESPONSIVE,
    );

    /**
     * @param array $Children
     *   Child nodes inserted into an object that may be used as an HTML
     *   parent container.
     */
    protected $Children = array();

    /**
     * @var array $SupportedLayouts
     *   The `layout` attribute values that are supported by an AMP HTML
     *   component.  By default, this attribute is set to `layout="responsive"`
     *   for most AMP components.
     */
    protected $SupportedLayouts = array(
        LayoutInterface::LAYOUT_CONTAINER,
        LayoutInterface::LAYOUT_FILL,
        LayoutInterface::LAYOUT_FIXED,
        LayoutInterface::LAYOUT_FIXED_HEIGHT,
        LayoutInterface::LAYOUT_FLEX_ITEM,
        LayoutInterface::LAYOUT_INTRINSIC,
        LayoutInterface::LAYOUT_NODISPLAY,
        LayoutInterface::LAYOUT_RESPONSIVE,
    );

    /**
     * Get an attribute.
     *
     * @param string $name
     *   Name of the attribute to get.
     *
     * @return string|int|null
     *   Returns the attribute or null of the attribute does not exist.
     */
    public function __get($name)
    {
        $name = strtolower($name);
        if (array_key_exists($name, $this->Attributes)) {
            return $this->Attributes[$name];
        } else {
            return null;
        }
    }

    /**
     * Set an attribute.
     *
     * @param string $name
     *   Name of the attribute to set.
     *
     * @param mixed $value
     *   Value of the attribute to set.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $name = strtolower($name);
        switch ($name) {
            case 'layout':
                $this->setLayout($value);
                break;
            default:
               $this->Attributes[$name] = $value;
        }
    }

    /**
     * Get the AMP layout attribute.
     *
     * @param void
     *
     * @return string
     *   Returns the currently set AMP HTML `layout` attribute as a string.
     */
    public function getLayout()
    {
        return $this->Attributes['layout'];
    }

    /**
     * Add an HTML child node.
     *
     * @param string $node
     *   HTML node to add to the children of the AMP component.
     *
     * @return void
     */
    public function insert($node)
    {
        array_push($this->Children, (string)$node);
    }

    /**
     * Set the layout attribute.
     *
     * @param string $layout
     *   String value for the AMP `layout` attribute.  Must be one of the values
     *   in the `$SupportedLayouts` array.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$layout` parameter is not
     *   a string or an unsupported layout.
     */
    public function setLayout($layout)
    {
        if (!is_string($layout)) {
            throw new \InvalidArgumentException();
        }
        $layout = strtolower($layout);

        if (!in_array($layout, $this->SupportedLayouts)) {
            throw new \InvalidArgumentException();
        }

        $this->Attributes['layout'] = $layout;
    }
}
