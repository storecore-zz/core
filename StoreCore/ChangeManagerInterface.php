<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Change Manager Interface
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2016-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
interface ChangeManagerInterface
{
    /**
     * Notify all registered observers.
     *
     * @param void
     * @return void
     */
    public function notify();

    /**
     * Register a subject and its observer.
     *
     * @param \StoreCore\SubjectInterface $subject
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function register(\StoreCore\SubjectInterface $subject, \StoreCore\ObserverInterface $observer);

    /**
     * Unregister a registered subject and observer.
     *
     * @param \StoreCore\SubjectInterface $subject
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function unregister(\StoreCore\SubjectInterface $subject, \StoreCore\ObserverInterface $observer);
}
