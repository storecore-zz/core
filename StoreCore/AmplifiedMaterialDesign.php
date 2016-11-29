<?php
namespace StoreCore;

/**
 * Amplified Material Design (AMD)
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class AmplifiedMaterialDesign extends MaterialDesignLite
{
    const VERSION = '0.1.0';

    /**
     * Extreme minification.
     *
     * By default the parent method MaterialDesignLite::minify() uses readable
     * shorthand replacements for MDL CSS class names.  This method adds an
     * additional minification by using even shorter class names from
     * `ma` to `mz` and then `maa` to `mzz`.
     *
     * @param bool $minify
     * @return void
     * @uses \StoreCore\MaterialDesignLite::minify()
     */
    public function minify($minify = true)
    {
        if ($minify !== false) {
            $i = 97;
            $j = 0;
            foreach ($this->MaterialDesignReplacements as $key => $value) {
                $replacement = 'm' . chr($i);
                if ($j !== 0) {
                    $replacement .= chr($j);
                }

                $this->MaterialDesignReplacements[$key] = $replacement;

                if ($j === 0) {
                    $i = $i + 1;
                    if ($i === 123) {
                        $i = 98;
                        $j = 97;
                    }
                } else {
                    $j = $j + 1;
                    if ($j === 123) {
                        $i = $i + 1;
                        $j = 97;
                    }
                }
            }
        }

        parent::minify($minify);
    }
}
