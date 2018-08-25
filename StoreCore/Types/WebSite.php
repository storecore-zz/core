<?php
namespace StoreCore\Types;

/**
 * Schema.org WebSite
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/WebSite
 * @see       https://developers.google.com/search/docs/data-types/sitename
 * @version   0.1.0
 */
class WebSite extends CreativeWork
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('WebSite');
    }

    /**
     * Set the website URL and add a Google sitelinks searchbox.
     *
     * @param string $url
     *   URL of the website, usually the homepage.
     *
     * @param bool $is_searchable
     *   Determines if the site is searchable (default true) or not (false).
     *
     * @return void
     *
     * @see https://developers.google.com/search/docs/data-types/sitelinks-searchbox
     *      Sitelinks Searchbox - Google Search at Google Developers
     *
     * @uses \StoreCore\Types\SearchAction
     */
    public function setURL($url, $is_searchable = true)
    {
        parent::setURL($url);

        if ($is_searchable !== false) {
            $search_action = new SearchAction();
            $search_action->setTarget(rtrim($url, '/') . '/?q={search_term_string}');
            $search_action->setQueryInput('required name=search_term_string');
            $this->setPotentialAction($search_action);
        }
    }
}
