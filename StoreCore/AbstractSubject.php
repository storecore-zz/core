<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Abstract Subject
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
abstract class AbstractSubject implements SubjectInterface
{
    const VERSION = '0.1.0';

    /** @var array $Observers */
    private $Observers = array();

    /**
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function attach(\StoreCore\ObserverInterface $observer)
    {
        $id = spl_object_hash($observer);
        $this->Observers[$id] = $observer;
    }

    /**
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function detach(\StoreCore\ObserverInterface $observer)
    {
        $id = spl_object_hash($observer);
        unset($this->Observers[$id]);
    }

    /**
     * @param void
     * @return void
     */
    public function notify()
    {
        foreach ($this->Observers as $observer) {
            $observer->update($this);
        }
    }
}
