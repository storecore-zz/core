<?php
namespace StoreCore;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundException;

/**
 * Cookie Container
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class CookieContainer implements ContainerInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $Data
     *  Data container for cookie key/value parameters.
     */
    private $Data = array();

    /**
     * Create a cookie container.
     *
     * @param array|null $cookie_parameters
     *   Cookie key/value pairs with the generic data structure of the PHP
     *   superglobal `$_COOKIE` and the `ServerRequest::getCookieParams()`
     *   return value.
     *
     * @return self
     */
    public function __construct(array $cookie_parameters = null)
    {
        if ($cookie_parameters !== null) {
            if (!is_array($cookie_parameters)) {
                throw new \InvalidArgumentException();
            }
            $this->Data = $cookie_parameters;
        }
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException();
        }

        return base64_decode($this->Data[$id]);
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return array_key_exists($id, $this->Data);
    }
}
