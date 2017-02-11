<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Observers/Subject Attacher
 *
 * This helper class contains a single static method populate() to attach
 * all stored observers to a given subject.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class SubjectObservers
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Attachs observers to a subject.
     *
     * @param \StoreCore\SubjectInterface &$subject
     * @return void
     */
    public static function populate(\StoreCore\SubjectInterface &$subject)
    {
        $subject_class = get_class($subject);
        $model = new \StoreCore\Database\Observers(\StoreCore\Registry::getInstance());
        $observers = $model->getSubjectObservers($subject_class);
        if ($observers === null) {
            return;
        }

        foreach ($observers as $observer_id => $observer_class) {
            $observer = new $observer_class();
            $subject->attach($observer);
        }
    }
}
