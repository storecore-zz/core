<?php
namespace StoreCore;

use \Psr\Http\Message\RequestFactoryInterface;
use \Psr\Http\Message\RequestInterface;
use \StoreCore\Request;

/**
 * PSR-17 compliant factory for requests.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class RequestFactory implements RequestFactoryInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function createRequest($method, $uri)
    {
        $request = new Request();
        try {
            $request->setMethod($method);
            $request->setUri($uri);
            return $request;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
