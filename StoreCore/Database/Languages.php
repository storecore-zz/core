<?php
namespace StoreCore\Database;

/**
 * Languages
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
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
class Languages extends AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * @var null|array $EnabledLanguages
     *   Array containing the currently enabled languages.
     */
    private $EnabledLanguages;

    /**
     * Disable a language.
     *
     * @param string $language_id
     * @return void
     */
    public function disable($language_id)
    {
        $language_id = $this->filterLanguageCode($language_id);
        $stmt = $this->Connection->prepare('UPDATE sc_languages SET enabled_flag = 0, sort_order = 0 WHERE language_id = :language_id');
        $stmt->bindParam(':language_id', $language_id, \PDO::PARAM_STR);
        $stmt->execute();
        $this->EnabledLanguages = null;
    }

    /**
     * Enable a language.
     *
     * @param string $language_id
     * @return void
     */
    public function enable($language_id)
    {
        $language_id = $this->filterLanguageCode($language_id);
        $stmt = $this->Connection->prepare('UPDATE sc_languages SET enabled_flag = 1 WHERE language_id = :language_id');
        $stmt->bindParam(':language_id', $language_id, \PDO::PARAM_STR);
        $stmt->execute();
        $this->EnabledLanguages = null;
    }

    /**
     * Check if a language ID exists.
     *
     * @param string $language_id
     * @return bool
     */
    public function exists($language_id)
    {
        $language_id = $this->filterLanguageCode($language_id);
        $stmt = $this->Connection->prepare('SELECT COUNT(language_id) FROM sc_languages WHERE language_id = :language_id');
        $stmt->bindParam(':language_id', $language_id, \PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn(0);
        return ($count == 1) ? true : false;
    }

    /**
     * Filter and possibly map a language code.
     *
     * @param string $language_id
     * @return string
     * @throws \InvalidArgumentException
     */
    public function filterLanguageCode($language_id)
    {
        if (!is_string($language_id)) {
            throw new \InvalidArgumentException();
        }

        $language_id = trim($language_id);
        $strlen = strlen($language_id);
        if ($strlen === 5) {
            $language_id = str_ireplace('_', '-', $language_id);
            $arr = explode('-', $language_id);
            if (is_array($arr) && count($arr) === 2) {
                $language_id = strtolower($arr[0]) . '-' . strtoupper($arr[1]);
            }
        } elseif ($strlen === 2) {
            /*
                  SELECT language_id
                    FROM sc_languages
                   WHERE SUBSTRING(language_id, 1, 2) = :language_id
                ORDER BY enabled_flag DESC,
                         language_id = parent_id DESC
                   LIMIT 1
             */
            $language_id = strtolower($language_id);
            $stmt = $this->Connection->prepare('SELECT language_id FROM sc_languages WHERE SUBSTRING(language_id, 1, 2) = :language_id ORDER BY enabled_flag DESC, language_id = parent_id DESC LIMIT 1');
            $stmt->bindParam(':language_id', $language_id, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            if ($row !== false && count($row) === 1) {
                return $row['language_id'];
            }
        } elseif ($strlen === 3) {
            $language_id = strtolower($language_id);
            // Map an ISO 639-2 B/T alpha-3 or ISO 639-3 language code to a language ID.
            $iso_map = array(
                'afr' => 'af-ZA',
                'deu' => 'de-DE',
                'dut' => 'nl-NL',
                'est' => 'et-EE',
                'eus' => 'eu-ES',
                'fra' => 'fr-FR',
                'fre' => 'fr-FR',
                'ger' => 'de-DE',
                'guj' => 'gu-IN',
                'heb' => 'he-IL',
                'ita' => 'it-IT',
                'kat' => 'ka-GE',
                'ltz' => 'lb-LU',
                'nld' => 'nl-NL',
                'nob' => 'nb-NO',
                'por' => 'pt-PT',
                'spa' => 'es-ES',
            );
            if (array_key_exists($language_id, $iso_map)) {
                return $iso_map[$language_id];
            }
        }

        return $language_id;
    }

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
        $stmt = $this->Connection->prepare('SELECT language_id, english_name FROM sc_languages WHERE enabled_flag = 1 ORDER BY sort_order ASC, english_name ASC');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $languages[$row['language_id']] = $row['english_name'];
        }
        $stmt->closeCursor();

        $this->EnabledLanguages = $languages;
        return $languages;
    }

    /**
     * Get local language names.
     *
     * @param bool $include_disabled_languages
     * @return array
     */
    public function getLocalNames($include_disabled_languages = false)
    {
        $sql = 'SELECT language_id, local_name FROM sc_languages ';
        if (!$include_disabled_languages) {
            $sql .= 'WHERE enabled_flag = 1 ';
        }
        $sql .= 'ORDER BY sort_order ASC, local_name ASC';

        $rows = array();
        $stmt = $this->Connection->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[$row['language_id']] = $row['local_name'];
        }
        $stmt->closeCursor();
        return $rows;
    }

    /**
     * Get all currently supported languages.
     *
     * @param void
     *
     * @return array
     *   Returns an array of language identifiers and (local) language names
     *   for the languages that currently are included in the StoreCore
     *   translation memory (TM).
     */
    public function getSupportedLanguages()
    {
        /*
              SELECT language_id, IFNULL(local_name, english_name) AS language_name
                FROM sc_languages
               WHERE language_id IN (SELECT DISTINCT language_id FROM sc_translation_memory)
            ORDER BY sort_order ASC, language_name ASC
         */
        $rows = array();
        $stmt = $this->Connection->prepare('SELECT language_id, IFNULL(local_name, english_name) AS language_name FROM sc_languages WHERE language_id IN (SELECT DISTINCT language_id FROM sc_translation_memory) ORDER BY sort_order ASC, language_name ASC');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[$row['language_id']] = $row['language_name'];
        }
        $stmt->closeCursor();
        unset($stmt);

        // Count versions of a language.
        $language_counter = array();
        foreach ($rows as $key => $value) {
            $key = substr($key, 0, 2);
            if (array_key_exists($key, $language_counter)) {
                $language_counter[$key] += 1;
            } else {
                $language_counter[$key] = 1;
            }
        }

        // Display 'Language' or 'Language (Country)'.
        foreach ($rows as $key => $value) {
            $value = explode(' - ', $value);
            if (is_array($value) && count($value) === 2) {
                $counter_key = substr($key, 0, 2);
                if ($language_counter[$counter_key] === 1) {
                    $rows[$key] = $value[0];
                } else {
                    $rows[$key] = $value[0] . ' (' . $value[1] . ')';
                }
            }
        }

        return $rows;
    }

    /**
     * Check if a language is enabled.
     *
     * @param string $language_id
     * @return bool
     * @uses getEnabledLanguages()
     */
    public function isEnabled($language_id)
    {
        return array_key_exists($language_id, $this->getEnabledLanguages());
    }
}
