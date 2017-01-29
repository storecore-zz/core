<?php
namespace StoreCore;

/**
 * Observer Design Pattern - Observer Interface
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
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
