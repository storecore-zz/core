<?php
namespace StoreCore\Types;

/**
 * Schema.org Search Action
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/SearchAction
 * @version   0.1.0
 */
class SearchAction extends Action
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'searchaction' => 'SearchAction',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('SearchAction');
    }

    /**
     * Set the search query input parameters.
     *
     * @param string $query_input
     *
     * @return void
     */
    public function setQueryInput($query_input = 'required name=search_term_string')
    {
        $this->setStringProperty('query-input', $query_input);
    }
}
