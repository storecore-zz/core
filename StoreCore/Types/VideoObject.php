<?php
namespace StoreCore\Types;

/**
 * Schema.org Media Object
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/VideoObject
 * @see       https://developers.google.com/search/docs/data-types/videos
 * @version   0.1.0
 */
class VideoObject extends MediaObject
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'videoobject' => 'VideoObject',
    );

    /**
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->setType('VideoObject');
        $this->setSchemaVersion('http://schema.org/version/3.1/');
    }
}
