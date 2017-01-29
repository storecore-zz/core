<?php
namespace StoreCore\Database;

/**
 * Observer Design Pattern - Observers
 *
 * This model class serves as a global registry for the observer design
 * pattern.  It stores observers and links them to their subjects.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Observers extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Get all observer class names for a given subject.
     *
     * @param $subject_class
     *   Class name of the observed subject class.
     *
     * @return array|null
     *   Returns an array or null if no observers were found.
     *
     * @throws \InvalidArgumentException
     */
    public function getSubjectObservers($subject_class)
    {
        if (!is_string($subject_class)) {
            throw new \InvalidArgumentException();
        }
        $subject_class = '\\' . trim($subject_class, '\\');

        try {
            $stmt = $this->Connection->prepare('
                   SELECT o.observer_id, o.observer_class, o.observer_name
                     FROM sc_observers o
                LEFT JOIN sc_subjects s
                       ON o.subject_id = s.subject_id
                    WHERE s.subject_class = :subject_class
            ');
            $stmt->bindParam(':subject_class', $subject_class, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt = null;
        } catch (\PDOException $e) {
            return null;
        }

        if (empty($result)) {
            return null;
        }

        $observers = array();
        foreach ($result as $observer) {
            $key = $observer['observer_name'] === null ? $observer['observer_id'] : $observer['observer_name'];
            $observers[$key] = $observer['observer_class'];
        }
        return $observers;
    }
}
