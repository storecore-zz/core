<?php
namespace StoreCore\Admin;

use StoreCore\Admin\ManifestModel;
use StoreCore\AbstractController;
use StoreCore\Registry;
use StoreCore\ResponseFactory;
use StoreCore\View;

/**
 * Administration Web App Manifest Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class ManifestController extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Create a web app manifest in JSON.
     *
     * @param Registry $registry
     *
     * @return self
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        $this->Model = new ManifestModel($this->Registry);
        $manifest_members = array(
            'manifest_version' => ManifestModel::MANIFEST_VERSION,
            'name' => $this->Model->getName(),
            'short_name' => $this->Model->getShortName(),
            'start_url' => 'https://' . $this->Location->getHost() . '/admin/',
            'background_color' => $this->Model->getBackgroundColor(),
            'theme_color' => $this->Model->getThemeColor(),
        );

        $this->View = new View();
        $this->View->setTemplate(__DIR__ .  DIRECTORY_SEPARATOR . 'ManifestTemplate.phtml');
        $this->View->setValues($manifest_members);
        $manifest = $this->View->render();

        $factory = new ResponseFactory();
        $response = $factory->createResponse();
        $this->Response->addHeader('Content-Type: application/manifest+json;charset=UTF-8');
        $this->Response->setResponseBody($manifest);
        $this->Response->output();
    }
}
