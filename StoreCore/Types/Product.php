<?php
namespace StoreCore\Types;

/**
 * Schema.org Product
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Product
 * @see       https://developers.google.com/search/docs/data-types/products
 * @version   0.1.0
 */
class Product extends Thing
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'individualproduct' => 'IndividualProduct',
        'product' => 'Product',
        'productmodel' => 'ProductModel',
        'someproducts' => 'SomeProducts',
        'vehicle' => 'Vehicle',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Product');
    }

    /**
     * Set the overall rating of the product.
     *
     * @param AggregateRating $aggregate_rating
     *   The overall rating, based on a collection of reviews or ratings, of
     *   the product.
     *
     * @return $this
     */
    public function setAggregateRating(AggregateRating $aggregate_rating)
    {
        $this->Data['aggregateRating'] = $aggregate_rating;
        return $this;
    }

    /**
     * Set the brand name.
     *
     * @param Brand|Organization|string $brand
     *   In Schema.org data structures the `brand` property is a Brand or
     *   Organization object.  Google however, only seems to use the brand
     *   name as a text value.  This method therefore accepts an instance of
     *   an Organization object, but only uses its name through the inherited
     *   Thing::getName() method.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setBrand($brand)
    {
        if ($brand instanceof Brand) {
            $this->Data['brand'] = $brand;
        } elseif ($brand instanceof Organization) {
            $organization = $brand;
            $brand = new Brand();
            $brand->setName($organization->getName());
            $this->Data['brand'] = $brand;
        } elseif (is_string($brand)) {
            $brand_name = $brand;
            $brand = new Brand();
            $brand->setName($brand_name);
            $this->Data['brand'] = $brand;
        } else {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    /**
     * Set the Global Trade Item Number (GTIN).
     *
     * @param InternationalArticleNumber|string $gtin
     * @return $this
     * @throws \InvalidArgumentException
     * @throws \LengthException
     */
    public function setGTIN($gtin)
    {
        if (!is_string($gtin)) {
            if (is_numeric($gtin) || $gtin instanceof InternationalArticleNumber) {
                $gtin = (string)$gtin;
            } else {
                throw new \InvalidArgumentException();
            }
        }

        $gtin = trim($gtin);
        $strlen = strlen($gtin);
        if ($strlen === 13) {
            $this->Data['gtin13'] = $gtin;
        } elseif ($strlen === 12) {
            $this->Data['gtin12'] = $gtin;
        } elseif ($strlen === 8) {
            $this->Data['gtin8'] = $gtin;
        } elseif ($strlen === 14) {
            $this->Data['gtin14'] = $gtin;
        } else {
            throw new \LengthException();
        }

        return $this;
    }

    /**
     * Set the Manufacturer Part Number (MPN).
     *
     * @param mixed $mpn
     * @return $this
     */
    public function setMPN($mpn)
    {
        $this->Data['mpn'] = $mpn;
        return $this;
    }

    /**
     * Set an offer to provide this item.
     *
     * @param Offer|float|int $offers
     * @return $this
     */
    public function setOffers($offers)
    {
        if (is_float($offers) || is_int($offers)) {
            $offers = new Offer($offers);
        }
        $this->Data['offers'] = $offers;
        return $this;
    }

    /**
     * Set the Stock Keeping Unit (SKU).
     *
     * @param mixed $sku
     * @return $this
     */
    public function setSKU($sku)
    {
        $this->Data['sku'] = $sku;
        return $this;
    }

}
