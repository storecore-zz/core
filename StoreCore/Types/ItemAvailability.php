<?php
namespace StoreCore\Types;

/**
 * Schema.org ItemAvailability.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/ItemAvailability
 * @see       https://developers.google.com/search/docs/data-types/product
 * @see       https://support.google.com/merchants/answer/7353427?hl=en
 * @version   0.1.0
 */
class ItemAvailability extends Varchar implements TypeInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $EnumerationMembers
     *   Fixed list of possible item availability options as schema.org URLs.
     */
    private $EnumerationMembers = array(
        1 => 'https://schema.org/Discontinued',
        2 => 'https://schema.org/InStock',
        3 => 'https://schema.org/InStoreOnly',
        4 => 'https://schema.org/LimitedAvailability',
        5 => 'https://schema.org/OnlineOnly',
        6 => 'https://schema.org/OutOfStock',
        7 => 'https://schema.org/PreOrder',
        8 => 'https://schema.org/PreSale',
        9 => 'https://schema.org/SoldOut',
    );

    /**
     * @inheritDoc
     */
    public function __construct($initial_value = 'https://schema.org/InStock', $strict = true)
    {
        if (!$strict) {
            // Accept numbers if not in strict mode.
            if (is_numeric($initial_value)) {
                $initial_value = intval($initial_value);
                if (array_key_exists($initial_value, $this->EnumerationMembers)) {
                    $initial_value = $this->EnumerationMembers[$initial_value];
                } else {
                    throw new \InvalidArgumentException();
                }
            } else {
                // Accept https:// instead of http:// if not in strict mode.
                if (substr($initial_value, 0, 7) === 'http://') {
                    $initial_value = str_replace('http://', 'https://', $initial_value);
                }
            }
        }

        if (!in_array($initial_value, $this->EnumerationMembers)) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($initial_value, $strict);
    }
}
