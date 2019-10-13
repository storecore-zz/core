<?php
namespace StoreCore\FileSystem;

use StoreCore\Database\Robots as RobotsModel;

use StoreCore\AbstractController;
use StoreCore\Registry;
use StoreCore\ResponseFactory;

/**
 * Robots Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.2.0
 */
class Robots extends AbstractController
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.2.0';

    /**
     * @var \StoreCore\Database\Robots $Model
     *   Data model for the robots.txt file.
     */
    private $Model;

    /**
     * @var string $View
     *   Contents of the robots.txt file as an MVC view.
     */
    private $View;

    /**
     * Create and publish robots.txt file.
     *
     * @param \StoreCore\Registry $registry
     *   Global StoreCore service locator.
     *
     * @return void
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);

        /*
            User-agent: *
            Crawl-delay: 5
            Disallow:
         */
        $this->View  = 'User-agent: *' . "\n";
        $this->View .= 'Crawl-delay: ';
        if (\defined('STORECORE_CMS_CRAWL_DELAY')) {
            $this->View .= STORECORE_CMS_CRAWL_DELAY;
        } else {
            $this->View .= 5;
        }
        $this->View .= "\n";
        $this->View .= 'Disallow: ' . "\n\n";

        $this->View .= 'Sitemap: ' . $this->Location->getScheme() . '://' . $this->Location->getHost() . '/sitemap.xml' . "\n\n";

        $this->loadModel();
        $this->renderView();
        $this->respond();
    }

    /**
     * @param void
     * @return void
     */
    private function loadModel()
    {
        $this->Model = new RobotsModel($this->Registry);
    }

    /**
     * @param void
     * @return void
     */
    private function renderView()
    {
        $robots = $this->Model->getAllDisallows();

        if (is_array($robots)) {
            $view = (string) null;

            foreach ($robots as $user_agent => $paths) {

                $view .= 'User-agent: ' . $user_agent . "\n";

                if ($user_agent === '*') {
                    $view .= 'Crawl-delay: ';
                    if (\defined('STORECORE_CMS_CRAWL_DELAY')) {
                        $view .= STORECORE_CMS_CRAWL_DELAY;
                    } else {
                        $view .= 5;
                    }
                    $view .= "\n";
                }

                foreach ($paths as $path) {
                    $view .= 'Disallow: ' . $path . "\n";
                }

                $view .= "\n";
            }

            $this->View .= $view;
        }
    }

    /**
     * @param void
     * @return void
     */
    private function respond()
    {
        $factory = new ResponseFactory();
        $response = $factory->createResponse();
        $response->addHeader('Content-Type: text/plain;charset=UTF-8');
        $response->setCompression(-1);
        $response->setResponseBody($this->View);
        $response->output();
    }
}
