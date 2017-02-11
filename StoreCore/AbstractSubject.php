<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Abstract Subject
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
abstract class AbstractSubject implements SubjectInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /** @var array $Observers */
    protected $Observers = array();

    /**
     * Attach an observer.
     *
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function attach(\StoreCore\ObserverInterface $observer)
    {
        $id = spl_object_hash($observer);
        $this->Observers[$id] = $observer;
    }

    /**
     * Detach an attached observer.
     *
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function detach(\StoreCore\ObserverInterface $observer)
    {
        $id = spl_object_hash($observer);
        unset($this->Observers[$id]);
    }

    /**
     * Notify and update all attached observers.
     *
     * @param void
     * @return void
     * @uses \StoreCore\ObserverInterface::update()
     */
    public function notify()
    {
        if (empty($this->Observers)) {
            return;
        }

        foreach ($this->Observers as $observer) {
            $observer->update($this);
        }
    }
}
