<?php
namespace StoreCore\Types;

/**
 * Schema.org Action
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Action
 * @version   0.1.0
 */
class Action extends Thing
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'achieveaction' => 'AchieveAction',
        'action' => 'Action',
        'assessaction' => 'AssessAction',
        'consumeaction' => 'ConsumeAction',
        'controlaction' => 'ControlAction',
        'createaction' => 'CreateAction',
        'findaction' => 'FindAction',
        'interactaction' => 'InteractAction',
        'moveaction' => 'MoveAction',
        'organizeaction' => 'OrganizeAction',
        'playaction' => 'PlayAction',
        'searchaction' => 'SearchAction',
        'tradeaction' => 'TradeAction',
        'transferaction' => 'TransferAction',
        'updateaction' => 'UpdateAction',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Action');
    }

    /**
     * Set the target EntryPoint for an Action.
     *
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->setProperty('target', $target);
        return $this;
    }
}
