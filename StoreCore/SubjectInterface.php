<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Subject Interface
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
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
     * Notify all attached observers.
     *
     * @param void
     * @return void
     */
    public function notify();
}
