<?php
namespace StoreCore\FileSystem;

/**
 * Robots Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version   0.1.0
 */
class Robots extends \StoreCore\AbstractController
{
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\Database\Robots $Model
     * @var string $View
     */
    private $Model;
    private $View = "User-agent: *\nDisallow:";

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        parent::__construct($registry);
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
        $this->Model = new \StoreCore\Database\Robots($this->Registry);
    }

    /**
     * @param void
     * @return void
     */
    private function renderView()
    {
        $robots = $this->Model->getAllDisallows();

        if (is_array($robots)) {
            $view = (string)null;
            foreach ($robots as $user_agent => $paths) {
                $view .= 'User-agent: ' . $user_agent . "\n";
                foreach ($paths as $path) {
                    $view .= 'Disallow: ' . $path . "\n";
                }
                if ($user_agent == '*') {
                    $view .= "Crawl-delay: 5\n";
                }
                $view .= "\n";
            }
            $this->View = $view;
        }
    }

    /**
     * @param void
     * @return void
     */
    private function respond()
    {
        $response = new \StoreCore\Response($this->Registry);
        $response->addHeader('Content-Type: text/plain;charset=UTF-8');
        $response->setCompression(-1);
        $response->setResponseBody($this->View);
        $response->output();
    }
}
