<?php
namespace StoreCore\Types;

/**
 * Schema.org Place
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Place
 * @version   0.1.0
 */
class Place extends Thing
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'accommodation' => 'Accommodation',
        'administrativearea' => 'AdministrativeArea',
        'civicstructure' => 'CivicStructure',
        'landform' => 'Landform',
        'landmarksorhistoricalbuildings' => 'LandmarksOrHistoricalBuildings',
        'localbusiness' => 'LocalBusiness',
        'place' => 'Place',
        'residence' => 'Residence',
        'touristattraction' => 'TouristAttraction',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Place');
    }

    /**
     * Set the geographic coordinates of a place.
     *
     * @param GeoCoordinates $geo
     *
     * @return void
     */
    public function setGeo(GeoCoordinates $geo)
    {
        $this->Data['geo'] = $geo;
    }
}
