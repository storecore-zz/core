<?php
namespace StoreCore\Types;

/**
 * Schema.org Offer
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Offer
 * @version   0.1.0
 */
class Offer extends Intangible
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'aggregateoffer' => 'AggregateOffer',
        'offer' => 'Offer',
    );

    /**
     * @param float|null $price
     * @param string|null $price
     * @return void
     * @uses \StoreCore\Types\AbstractRichSnippet::setType()
     * @uses \StoreCore\Types\Offer::setAvailability()
     * @uses \StoreCore\Types\Offer::setItemCondition()
     * @uses \StoreCore\Types\Offer::setPrice()
     * @uses \StoreCore\Types\Offer::setPriceCurrency()
     */
    public function __construct($price = null, $price_currency = 'EUR')
    {
        $this->setType('Offer');

        if ($price !== null) {
            $this->setPrice($price);
        }

        if ($price_currency === null) {
            $price_currency = 'EUR';
        }
        $this->setPriceCurrency($price_currency);

        // Items on offer are in stock and new by default.
        $this->setAvailability('http://schema.org/InStock');
        $this->setItemCondition('http://schema.org/NewCondition');
    }

    /**
     * Set the offer availability.
     *
     * @param ItemAvailability|string $availability
     * @return $this
     * @see https://schema.org/ItemAvailability
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function setAvailability($availability)
    {
        if (is_string($availability)) {
            $item_availability = array(
                'discontinued' => 'http://schema.org/Discontinued',
                'instock' => 'http://schema.org/InStock',
                'instoreonly' => 'http://schema.org/InStoreOnly',
                'limitedavailability' => 'http://schema.org/LimitedAvailability',
                'onlineonly' => 'http://schema.org/OnlineOnly',
                'outofstock' => 'http://schema.org/OutOfStock',
                'preorder' => 'http://schema.org/PreOrder',
                'presale' => 'http://schema.org/PreSale',
                'soldout' => 'http://schema.org/SoldOut',
            );
            $availability = str_replace('http://schema.org/', null, $availability);
            $availability = str_replace('https://schema.org/', null, $availability);
            $availability = strtolower($availability);
            if (array_key_exists($availability, $item_availability)) {
                $availability = $item_availability[$availability];
            } else {
                throw new \OutOfRangeException();
            }
        } elseif (!$availability instanceof ItemAvailability) {
            throw new \InvalidArgumentException();
        }

        $this->Data['availability'] = $availability;
        return $this;
    }

    /**
     * Set the offered item's condition.
     *
     * @param OfferItemCondition|string $item_condition
     * @returm $this
     */
    public function setItemCondition($item_condition)
    {
        if (is_string($item_condition)) {
            $offer_item_conditions = array(
                'damagedcondition' => 'http://schema.org/DamagedCondition',
                'newcondition' => 'http://schema.org/NewCondition',
                'refurbishedcondition' => 'http://schema.org/RefurbishedCondition',
                'usedcondition' => 'http://schema.org/UsedCondition',
            );

            $item_condition = str_replace('http://schema.org/', null, $item_condition);
            $item_condition = str_replace('https://schema.org/', null, $item_condition);
            $item_condition = strtolower($item_condition);
            if (array_key_exists($item_condition, $offer_item_conditions)) {
                $item_condition = $offer_item_conditions[$item_condition];
            } else {
                throw new \OutOfRangeException();
            }
        } elseif (!$item_condition instanceof OfferItemCondition) {
            throw new \InvalidArgumentException();
        }

        $this->Data['itemCondition'] = $item_condition;
        return $this;
    }

    /**
     * Set the price.
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->Data['price'] = $price;
        return $this;
    }

    /**
     * Set the price currency.
     *
     * @param string $price_currency
     *
     * @return $this
     */
    public function setPriceCurrency($price_currency)
    {
        if (!is_string($price_currency)) {
            throw new \InvalidArgumentException();
        }

        $price_currency = trim($price_currency);
        $price_currency = strtoupper($price_currency);
        if (strlen($price_currency) !== 3) {
            throw new \InvalidArgumentException();
        }

        $this->Data['priceCurrency'] = $price_currency;
        return $this;
    }

    /**
     * Set the current price end date.
     *
     * @param DateTime|string $price_valid_until
     *   The date, in ISO 8601 date format, after which the price will no
     *   longer be available.  Note that a Google product snippet MAY not
     *   display if the `priceValidUtil` property indicates a past date.
     *
     * @return $this
     */
    public function setPriceValidUntil($price_valid_until)
    {
        $this->setDateProperty('priceValidUntil', $price_valid_until);
        return $this;
    }

    /**
     * Set the seller of an offered product.
     *
     * @param Organization|Person $seller
     * @return $this
     */
    public function setSeller($seller)
    {
        if (!$seller instanceof Organization && !$seller instanceof Person) {
            throw new \InvalidArgumentException();
        }

        $this->Data['seller'] = $seller;
        return $this;
    }
}
