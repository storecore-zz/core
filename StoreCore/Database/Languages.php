<?php
namespace StoreCore\Database;

/**
 * Languages
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.0.2
 */
class Languages extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.0.2';

    /**
     * @type null|array $EnabledLanguages
     */
    private $EnabledLanguages;

    /**
     * Get enabled languages.
     *
     * @api
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

        $this->EnabledLanguages = $languages;
        return $languages;
    }

    
    /**
     * Get languages and countries by their local name.
     *
     * @api
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
        return $rows;
    }
}
