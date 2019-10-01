<?php
namespace StoreCore;

use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \StoreCore\ServerRequest;

/**
 * PSR-17 compliant factory for server requests.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class ServerRequestFactory implements ServerRequestFactoryInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function createServerRequest($method, $uri, $serverParams = array())
    {
        $request = new ServerRequest();
        try {
            $request->setMethod($method);
            $request->setUri($uri);
            $request->setServerParams($serverParams);
            return $request;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
