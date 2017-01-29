<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Simple Change Manager
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class SimpleChangeManager implements ChangeManagerInterface
{
    const VERSION = '0.1.0';

    /** @var array $Subjects */
    protected $Subjects = array();

    /**
     * Notify all observers of all registered subjects.
     *
     * @param void
     * @return void
     */
    public function notify()
    {
        if (empty($this->Subjects)) {
            return;
        }

        foreach ($this->Subjects as $subject) {
            $subject->notify();
        }
    }

    /**
     * Register a subject and attach an observer.
     *
     * @param \StoreCore\SubjectInterface $subject
     * @param \StoreCore\ObserverInterface $observer
     * @return void
     */
    public function register(\StoreCore\SubjectInterface $subject, \StoreCore\ObserverInterface $observer)
    {
        $subject->attach($observer);

        $subject_id = spl_object_hash($subject);
        $this->Subjects[$subject_id] = $subject;
    }

    /**
     * Unregister a registered subject or one of its observers.
     *
     * @param \StoreCore\SubjectInterface $subject
     * @param \StoreCore\ObserverInterface|null $observer
     * @return void
     */
    public function unregister(\StoreCore\SubjectInterface $subject, \StoreCore\ObserverInterface $observer = null)
    {
        $subject_id = spl_object_hash($subject);
        if ($observer === null) {
            unset($this->Subjects[$subject_id]);
        } else {
            $this->Subjects[$subject_id]->detach($observer);
        }
    }
}
