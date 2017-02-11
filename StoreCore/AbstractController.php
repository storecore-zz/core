<?php
namespace StoreCore;

/**
 * Abstract MVC Controller
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
abstract class AbstractController
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /** @var \StoreCore\Registry $Registry */
    protected $Registry;

    /**
     * @param \StoreCore\Registry $registry
     * @return void
     */
    public function __construct(\StoreCore\Registry $registry)
    {
        $this->Registry = $registry;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->Registry->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->Registry->set($key, $value);
    }
}
