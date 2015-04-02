<?php
namespace StoreCore\Database;

/**
 * Languages
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @package   StoreCore\Database
 * @version   0.0.1
 */
class Languages extends \StoreCore\AbstractModel
{
    /**
     * @type string VERSION
     */
    const VERSION = '0.0.1';

    /**
     * @type null|array $Translations
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

        if ($this->Registry->has('Connection')) {
            $dbh = $this->Registry->get('Connection');
        } else {
            $dbh = new \StoreCore\Database\Connection();
            $this->Registry->set('Connection', $dbh);
        }

        $languages = array();
        $stmt = $dbh->prepare('SELECT language_id, iso_code FROM sc_languages WHERE status = 1 ORDER BY sort_order ASC, iso_code ASC');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $row['language_id'] = (int)$row['language_id'];
            $languages[$row['language_id']] = $row['iso_code'];
        }

        $this->EnabledLanguages = $languages;
        return $languages;
    }
}
