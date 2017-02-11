<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Subject Interface
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
interface SubjectInterface
{
    /**
     * Attach an observer.
     *
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function attach(\StoreCore\ObserverInterface $observer);

    /**
     * Detach an attached observer.
     *
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function detach(\StoreCore\ObserverInterface $observer);

    /**
     * Notify and update all attached observers.
     *
     * @param void
     * @return void
     */
    public function notify();
}
