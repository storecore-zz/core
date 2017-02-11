<?php
namespace StoreCore\Types;

/**
 * Schema.org Structured Value
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/StructuredValue
 * @version   0.1.0
 */
class StructuredValue extends Intangible
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'contactpoint' => 'ContactPoint',
        'enginespecification' => 'EngineSpecification',
        'geocoordinates' => 'GeoCoordinates',
        'geoshape' => 'GeoShape',
        'interactioncounter' => 'InteractionCounter',
        'monetaryamount' => 'MonetaryAmount',
        'nutritioninformation' => 'NutritionInformation',
        'openinghoursspecification' => 'OpeningHoursSpecification',
        'ownershipinfo' => 'OwnershipInfo',
        'pricespecification' => 'PriceSpecification',
        'propertyvalue' => 'PropertyValue',
        'quantitativevalue' => 'QuantitativeValue',
        'typeandquantitynode' => 'TypeAndQuantityNode',
        'warrantypromise' => 'WarrantyPromise',
    );
}
