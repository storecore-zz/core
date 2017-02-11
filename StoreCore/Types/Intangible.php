<?php
namespace StoreCore\Types;

/**
 * Schema.org Intangible Thing
 *
 * This abstract class is mainly included to mimic Schema.org hierarchies like:
 * Thing > Intangible > StructuredValue > ContactPoint.  Hierarchies like these
 * are implemented as an object stack:
 *
 * - class Thing
 * - class Intangible extends Thing
 * - class StructuredValue extends Intangible
 * - class ContactPoint extends StructuredValue
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Intangible
 * @version   0.1.0
 */
class Intangible extends Thing
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'alignmentobject' => 'AlignmentObject',
        'audience' => 'Audience',
        'beddetails' => 'BedDetails',
        'brand' => 'Brand',
        'broadcastchannel' => 'BroadcastChannel',
        'broadcastfrequencyspecification' => 'BroadcastFrequencySpecification',
        'bustrip' => 'BusTrip',
        'class' => 'Class',
        'computerlanguage' => 'ComputerLanguage',
        'datafeeditem' => 'DataFeedItem',
        'demand' => 'Demand',
        'digitaldocumentpermission' => 'DigitalDocumentPermission',
        'entrypoint' => 'EntryPoint',
        'enumeration' => 'Enumeration',
        'flight' => 'Flight',
        'gameserver' => 'GameServer',
        'healthinsuranceplan' => 'HealthInsurancePlan',
        'healthplancostsharingspecification' => 'HealthPlanCostSharingSpecification',
        'healthplanformulary' => 'HealthPlanFormulary',
        'healthplannetwork' => 'HealthPlanNetwork',
        'intangible' => 'Intangible',
        'invoice' => 'Invoice',
        'itemlist' => 'ItemList',
        'jobposting' => 'JobPosting',
        'language' => 'Language',
        'listitem' => 'ListItem',
        'offer' => 'Offer',
        'order' => 'Order',
        'orderitem' => 'OrderItem',
        'parceldelivery' => 'ParcelDelivery',
        'permit' => 'Permit',
        'programmembership' => 'ProgramMembership',
        'property' => 'Property',
        'propertyvaluespecification' => 'PropertyValueSpecification',
        'quantity' => 'Quantity',
        'rating' => 'Rating',
        'reservation' => 'Reservation',
        'role' => 'Role',
        'seat' => 'Seat',
        'service' => 'Service',
        'servicechannel' => 'ServiceChannel',
        'structuredvalue' => 'StructuredValue',
        'ticket' => 'Ticket',
        'traintrip' => 'TrainTrip',
    );
}
