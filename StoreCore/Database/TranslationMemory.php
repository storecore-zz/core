<?php
namespace StoreCore\Database;

/**
 * Translation Memory Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.0.3
 */
class TranslationMemory extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.0.3';

    /**
     * @var int $LanguageID        Unique identifier of the current language.
     * @var int $ParentLanguageID  Identifier of the parent or root language.
     */
    private $LanguageID = 0;
    private $ParentLanguageID = 0;

    /**
     * @var null|array $Translations
     */
    private $Translations;

    /**
     * Load translations as name/value pairs.
     *
     * @param int|string $language_code
     *   Internal language identifier (integer) or ISO language code (string).
     *   The numeric language ID is equal to the primary key and the
     *   self-referencing foreign key.
     *
     * @return array
     */
    public function getTranslations($language_code = null, $storefront = true)
    {
        if ($language_code !== null) {
            $this->setLanguage($language_code);
        }

        $storefront = (bool)$storefront;

        // Populate with British English (0) as the root language
        if ($this->Translations === null || $this->LanguageID == 0) {
            $this->Translations = array();
            $this->readTranslations(0, $storefront);
        }

        if ($this->LanguageID != 0) {
            if ($this->ParentLanguageID != 0 && $this->ParentLanguageID != $this->LanguageID) {
                $this->readTranslations($this->ParentLanguageID, $storefront);
            }
            $this->readTranslations($this->LanguageID, $storefront);
        }

        return $this->Translations;
    }

    /**
     * @param int $language_id
     * @param bool $storefront
     * @return void
     */
    private function readTranslations($language_id, $storefront)
    {
        $sql = 'SELECT translation_id AS name, translation AS value FROM sc_translation_memory WHERE language_id = ' . (int)$language_id;
        if ($storefront) {
            $sql .= ' AND admin_only_flag = 0';
        }
        $sql .= ' ORDER BY translation_id ASC';

        $stmt = $this->Connection->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->Translations[$row['name']] = $row['value'];
        }
    }

    /**
     * Set the language to load.
     *
     * @param int|string $language_code
     *   Internal language identifier (integer) or ISO language code (string).
     *
     * @return bool
     *   Returns true if the language was set or false if the language does not
     *   exist or is not enabled.
     */
    public function setLanguage($language_code)
    {
        if ($language_code == $this->LanguageID) {
            return true;
        }

        $sql = 'SELECT language_id, parent_id FROM sc_languages WHERE status = 1 ';
        if (is_string($language_code)) {
            $language_code = str_ireplace('_', '-', $language_code);
            if (strlen($language_code) == 2) {
                $language_code = strtolower($language_code);
                $sql .= "AND iso_code LIKE '" . $language_code . "%' ORDER BY parent_id <> language_id LIMIT 1";
            } else {
                $sql .= "AND iso_code = '" . $language_code . "'";
            }
        } elseif (is_int($language_code)) {
            $sql .= 'AND language_id = ' . $language_code;
        } else {
            return false;
        }

        $stmt = $this->Connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return false;
        } else {
            $this->LanguageID = (int)$row['language_id'];
            $this->ParentLanguageID = (int)$row['parent_id'];
            return true;
        }
    }
}
