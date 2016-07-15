<?php
namespace StoreCore;

/**
 * Material Design Components
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class MaterialDesignComponents
{
    const VERSION = '0.1.0';

    /**
     * @var array $EnabledComponents
     *   List of Material Design Lite (MDL) components to include (true) or
     *   exclude (false) in CSS links or CSS code.  Core MDL components that
     *   are always included, like mdl-card and mdl-menu, are located in the
     *   master MDL CSS file (currently mdl-v1.1.3.css and mdl-v1.1.3.min.css)
     *   and SHOULD NOT be added to this array.
     */
    private $EnabledComponents = array(
        'mdl-badge'       => false,
        'mdl-checkbox'    => false,
        'mdl-chip'        => false,
        'mdl-data-table'  => false,
        'mdl-dialog'      => false,
        'mdl-icon-toggle' => false,
        'mdl-mega-footer' => true,
        'mdl-mini-footer' => false,
        'mdl-progress'    => false,
        'mdl-radio'       => false,
        'mdl-slider'      => false,
        'mdl-snackbar'    => false,
        'mdl-spinner'     => false,
        'mdl-switch'      => false,
        'mdl-textfield'   => false,
        'mdl-tooltip'     => false,
    );

    /**
     * Enable a Material Design Lite (MDL) component.
     *
     * @param string $component
     *   The name of an MDL component or a list of multiple component names,
     *   separated by a space, comma or semicolon.
     *
     * @return void
     */
    public function enable($component)
    {
        $component = trim($component);
        $component = strtolower($component);
        
        // Parse a list of multiple components
        $components = str_ireplace(',', ' ', $component);
        $components = str_ireplace(';', ' ', $components);
        $components = explode(' ', $components);
        if (count($components) > 1) {
            $components = array_filter($components);
            foreach ($components as $component) {
                $this->enable($component);
            }
            return;
        }
        unset($components);
        
        $component = ltrim($component, '.');
        if (array_key_exists($component, $this->EnabledComponents)) {
            $this->EnabledComponents[$component] = true;
        } elseif (array_key_exists('mdl-' . $component, $this->EnabledComponents)) {
            $this->enable('mdl-' . $component);
            return;
        }

        // Only allow one type of footer
        if ($component === 'mdl-mega-footer') {
            $this->EnabledComponents['mdl-mini-footer'] = false;
        } elseif ($component === 'mdl-mini-footer') {
            $this->EnabledComponents['mdl-mega-footer'] = false;
        }
    }

    /**
     * Get HTML links to minified MDL CSS files.
     *
     * @param void
     * @return string
     */
    public function getLinks()
    {
        $links = '<link href="/css/mdl-v1.1.3.min.css" rel="stylesheet">';
        foreach ($this->EnabledComponents as $component => $enabled) {
            if (true === $enabled) {
                $links .= '<link href="/css/' . $component . '.min.css" rel="stylesheet">';
            }
        }
        return $links;
    }

    /**
     * Get a single CSS style sheet.
     *
     * @param void
     * @return string
     */
    public function getStyle()
    {
        $assets_directory = realpath(__DIR__ . '/../assets/css') . DIRECTORY_SEPARATOR;
        if (!is_dir($assets_directory)) {
            return (string)null;
        }

        if (is_file($assets_directory . 'mdl-v1.1.3.min.css')) {
            $css = file_get_contents($assets_directory . 'mdl-v1.1.3.min.css');
        } else {
            $css = (string)null;
        }

        foreach ($this->EnabledComponents as $component => $enabled) {
            if (true === $enabled && is_file($assets_directory . $component . '.min.css')) {
                $css .= file_get_contents($assets_directory . $component . '.min.css');
            }
        }

        return $css;
    }
}
