<?php
namespace StoreCore;

/**
 * StoreCore Product Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Product extends AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\Types\ItemAvailability $Availability
     *   Schema.org item availability as an `ItemAvailability` object
     *   (https://schema.org/ItemAvailability).  Defaults to a
     *   `https://schema.org/InStock` product availability to prevent any
     *   disruption of ongoing product sales.
     */
    protected $Availability;

    /**
     * @var \DateTime|null $IntroductionDate
     *   The date and time the product was first introduced publicly.  Defaults
     *   to the date and time the product was added to the product catalog.
     */
    private $IntroductionDate;

    /**
     * @var \DateTime $ModificationDate
     *   The date and time the product data were last modified.
     */
    private $ModificationDate;

    /**
     * @var \StoreCore\Types\ProductID|null $ParentID
     *   Unique product identifier and primary key of a parent product.
     */
    private $ParentID;

    /**
     * @var \StoreCore\Types\ProductID|null $ProductID
     *   Unique product identifier.
     */
    private $ProductID;

    /**
     * @var bool $ServiceFlag
     *   Product is a good (default false) or a service (true).
     */
    private $ServiceFlag = false;

    /**
     * @var \DateTime|null $SalesDiscontinuationDate
     *   The date and time the product is no longer for sale.
     */
    private $SalesDiscontinuationDate;

    /**
     * @var \DateTime|null $SupportDiscontinuationDate
     *   The date and time the product is no longer supported.
     */
    private $SupportDiscontinuationDate;

    /**
     * Create a product data object.
     *
     * @param \StoreCore\Registry $registry
     *   Global service locator.
     *
     * @return self
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);
        $this->Availability = new \StoreCore\Types\ItemAvailability('https://schema.org/InStock', true);
        $this->setModificationDate();
    }

    /**
     * Get the product’s availability.
     *
     * @param void
     *
     * @return \StoreCore\Types\ItemAvailability
     *   Returns the product availability as a schema.org `ItemAvailability`
     *   data object.
     */
    public function getAvailability()
    {
        return $this->Availability;
    }

    /**
     * Get the product’s introduction date.
     *
     * @param void
     *
     * @return \DateTime|null
     *   Returns the product’s introduction date and time as a DateTime object
     *   or null if the product is not yet introduced.
     */
    public function getIntroductionDate()
    {
        return $this->IntroductionDate;
    }

    /**
     * Get the product’s modification date.
     *
     * @param void
     *
     * @return \DateTime
     *   Returns the date and time the product was last modified as a PHP
     *   DateTime object.
     */
    public function getModificationDate()
    {
        return $this->ModificationDate;
    }

    /**
     * Get the parent product identifier.
     *
     * @param void
     *
     * @return \StoreCore\Types\ProductID|null
     *   Returns the product ID of the parent product as an object or null if
     *   there is no parent product.
     */
    public function getParentID()
    {
        return $this->ParentID;
    }

    /**
     * Get the product identifier.
     *
     * @param void
     *
     * @return \StoreCore\Types\ProductID|null
     *   Returns the product ID as an object or null if the product does not
     *   have an ID yet.
     */
    public function getProductID()
    {
        return $this->ProductID;
    }

    /**
     * Get the product’s sales discontinuation date.
     *
     * @param void
     *
     * @return \DateTime|null
     *   Returns the date and time the product is no longer for sale or null if
     *   this date does not (yet) exist.
     */
    public function getSalesDiscontinuationDate()
    {
        return $this->SalesDiscontinuationDate;
    }

    /**
     * Get the product’s support discontinuation date.
     *
     * @param void
     *
     * @return \DateTime|null
     *   Returns the date and time the product is no longer supported or null
     *   if this date does not (yet) exist.
     */
    public function getSupportDiscontinuationDate()
    {
        return $this->SupportDiscontinuationDate;
    }

    /**
     * Determine if the product is a service.
     *
     * @param void
     *
     * @return bool
     *   Returns true if the product is a service or false if the product is
     *   a good.  By default, products in StoreCore are countable goods.
     */
    public function isService()
    {
        return $this->ServiceFlag;
    }

    /**
     * Set the product availability.
     *
     * @param \StoreCore\Types\ItemAvailability
     *   The product availability as a schema.org `ItemAvailability` object.
     *
     * @return void
     */
    public function setAvailability(\StoreCore\Types\ItemAvailability $availability)
    {
        $this->Availability = $availability;
    }

    /**
     * Set the product’s modification date.
     *
     * @param \DateTime|string $date_and_time
     *   The date and time the product data were last modified as a DateTime
     *   object or a date/time string.  If this optional parameter is omitted,
     *   the current date and time is set.
     *
     * @return void
     */
    public function setModificationDate($date_and_time = 'now')
    {
        if ($date_and_time instanceof \DateTime) {
            $this->ModificationDate = $date_and_time;
        } else {
            $this->ModificationDate = new \DateTime($date_and_time, new \DateTimeZone('UTC'));
        }
    }

    /**
     * Set the product identifier of the parent product.
     *
     * @param \StoreCore\Types\ProductID|int $parent_product_identifier
     *   Unique product ID of the parent product.
     *
     * @return void
     */
    public function setParentID($parent_product_identifier)
    {
        if ($parent_product_identifier instanceof \StoreCore\Types\ProductID) {
            $this->ParentID = $parent_product_identifier;
        } else {
            $this->ParentID = new \StoreCore\Types\ProductID($parent_product_identifier, false);
        }
    }

    /**
     * Set the product identifier.
     *
     * @param \StoreCore\Types\ProductID|int $product_identifier
     *   Unique product ID.  This product ID is determined by the (internal)
     *   primary key of the database but also serves as a (public) unique key
     *   to access products and product data through API’s.
     *
     * @return void
     */
    public function setProductID($product_identifier)
    {
        if ($product_identifier instanceof \StoreCore\Types\ProductID) {
            $this->ProductID = $product_identifier;
        } else {
            $this->ProductID = new \StoreCore\Types\ProductID($product_identifier, false);
        }
    }

    /**
     * Set the product’s sales discontinuation date.
     *
     * Products MAY be discontinued without removing them entirely by simply
     * setting a sales discontinuation date and time.
     *
     * @param \DateTime|string $date_and_time
     *   The date and time the product is no longer for sale.  If this optional
     *   parameter is omitted, the current date and time are set.
     *
     * @return void
     *
     * @uses \StoreCore\Product::setSupportDiscontinuationDate()
     *   If the product does not yet have a support discontinuation date,
     *   setting the sales discontinuation date will also set the support
     *   discontinuation date, with a default lag of two years.
     */
    public function setSalesDiscontinuationDate($date_and_time = 'now')
    {
        if ($date_and_time instanceof \DateTime) {
            $this->ModificationDate = $date_and_time;
        } else {
            $this->ModificationDate = new \DateTime($date_and_time, new \DateTimeZone('UTC'));
        }

        if ($this->getSupportDiscontinuationDate() === null) {
            $support_discontinuation_date = $this->ModificationDate;
            $date_interval = new \DateInterval('P2Y');
            $support_discontinuation_date->add($date_interval);
            $this->setSupportDiscontinuationDate($support_discontinuation_date);
        }
    }

    /**
     * Set the product’s support discontinuation date.
     *
     * @param \DateTime|string $date_and_time
     *   The date and time the product is no longer supported.
     *
     * @return void
     */
    public function setSupportDiscontinuationDate($date_and_time)
    {
        if ($date_and_time instanceof \DateTime) {
            $this->SupportDiscontinuationDate = $date_and_time;
        } else {
            $this->SupportDiscontinuationDate = new \DateTime($date_and_time, new \DateTimeZone('UTC'));
        }
    }
}
