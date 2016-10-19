<?php
namespace StoreCore\Database;

/**
 * Languages
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.0.3
 *
 * @todo Additional languages SHOULD be added to the two arrays
 *   $AdditionalPrimaryLanguages and $AdditionalSecondaryLanguages of this
 *   class first, so they can be added by an administration user.  Next they
 *   MAY be moved over to the master database table sc_languages in future
 *   versions or updates if the contain enough translations to run a decent
 *   store in the given language.
 *
 * @see https://en.wikipedia.org/wiki/World_language
 *      World language
 *
 * @see https://en.wikipedia.org/wiki/List_of_languages_by_number_of_native_speakers
 *      List of languages by number of native speakers
 *
 * @see https://en.wikipedia.org/wiki/Languages_of_Europe
 *      Languages of Europe
 *
 * @see https://en.wikipedia.org/wiki/Languages_of_the_European_Union
 *      Languages of the European Union
 *
 * @see https://msdn.microsoft.com/en-US/library/ee825488(v=cs.20).aspx
 *      Table of Language Culture Names, Codes, and ISO Values Method
 */
class Languages extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.0.3';

    /**
     * @var array $AdditionalPrimaryLanguages
     *   Primary (master) languages that are not included in the database by
     *   default.  The associative array key is an ISO 639-2 or ISO 639-3
     *   macrolanguage code.
     */
    private $AdditionalPrimaryLanguages = array(
        'afr' => array('af-ZA', 'Afrikaans - South Africa', 'Afrikaans - Suid-Afrika'),
        'est' => array('et-EE', 'Estonian - Estonia', 'Eesti'),
        'eus' => array('eu-ES', 'Basque - Basque', 'Euskara'),
        'guj' => array('gu-IN', 'Gujarati - India', 'ગુજરાતી'),
        'heb' => array('he-IL', 'Hebrew - Israel', 'עברית'),
        'isl' => array('is-IS', 'Icelandic - Iceland', 'Íslenska'),
        'kat' => array('ka-GE', 'Georgian - Georgia', 'ქართული'),
        'ltz' => array('lb-LU', 'Luxembourgish - Luxembourg', 'Lëtzebuergesch'),
        'nob' => array('nb-NO', 'Norwegian Bokmål - Norway', 'Bokmål - Norge'),
    );

    /**
     * @var array $AdditionalSecondaryLanguages
     */
    private $AdditionalSecondaryLanguages = array(
        'de-DE' => array(
            'de-LI' => array('German - Liechtenstein', 'Deutsch - Liechtenstein'),
        ),
        'fr-FR' => array(
            'fr-MC' => array('French - Monaco', 'Français - Monaco'),
        ),
        'nb-NO' => array(
            'nn-NO' => array('Norwegian Nynorsk - Norway', 'Nynorsk - Noreg'),
        ),
        'sv-SE' => array(
            'sv-FI' => array('Swedish - Finland', 'Finlandssvenska - Finland'),
        ),
    );

    /**
     * @var null|array $EnabledLanguages
     */
    private $EnabledLanguages;

    /**
     * Get enabled languages.
     *
     * @param void
     * @return array
     */
    public function getEnabledLanguages()
    {
        if ($this->EnabledLanguages !== null) {
            return $this->EnabledLanguages;
        }

        $languages = array();
        $stmt = $this->Connection->prepare('SELECT language_id, iso_code FROM sc_languages WHERE status = 1 ORDER BY sort_order ASC, iso_code ASC');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $row['language_id'] = (int)$row['language_id'];
            $languages[$row['language_id']] = $row['iso_code'];
        }
        $stmt->closeCursor();

        $this->EnabledLanguages = $languages;
        return $languages;
    }


    /**
     * Get local language names.
     *
     * @param void
     * @return array
     */
    public function getLocalNames($include_disabled_languages = false)
    {
        $sql = 'SELECT iso_code, local_name FROM sc_languages ';
        if (!$include_disabled_languages) {
            $sql .= 'WHERE status = 1 ';
        }
        $sql .= 'ORDER BY local_name ASC';

        $rows = array();
        $stmt = $this->Connection->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[$row['iso_code']] = $row['local_name'];
        }
        $stmt->closeCursor();
        return $rows;
    }
}
