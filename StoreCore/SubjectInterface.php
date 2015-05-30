<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Subject Interface
 *
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
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
