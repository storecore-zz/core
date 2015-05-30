<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Observer Interface
 *
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 */
interface ObserverInterface
{
    /**
     * Process an update from an observed subject.
     *
     * @param \StoreCore\SubjectInterface $subject
     * @return void
     */
    public function update(\StoreCore\SubjectInterface $subject);
}
