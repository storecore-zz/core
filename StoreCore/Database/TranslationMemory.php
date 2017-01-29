<?php
namespace StoreCore\Database;

/**
 * Translation Memory Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @internal
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\I18N
 * @version   0.1.0
 */
class TranslationMemory extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer). */
    const VERSION = '0.1.0';

    /**
     * @var string $LanguageID        Unique identifier of the current language.
     * @var string $ParentLanguageID  Identifier of the parent or root language.
     */
    private $LanguageID = 'en-GB';
    private $ParentLanguageID = 'en-GB';

    /**
     * @var null|array $Translations
     */
    private $Translations;

    /**
     * Find language strings in enabled languages.
     *
     * @param string $needle
     * @return array|null
     */
    public function find($needle)
    {
        $needle = trim($needle);
        if (empty($needle)) {
            return null;
        }

        /*
               SELECT t.translation_id, t.language_id, t.translation
                 FROM sc_translation_memory t
            LEFT JOIN sc_languages l
                   ON t.language_id = l.language_id
                WHERE l.enabled_flag = 1
                  AND (t.translation_id LIKE '%...%' OR t.translation LIKE '%...%')
         */
        $needle = '%' . trim($needle, '%') . '%';
        $uppercase_needle = strtoupper($needle);

        $stmt = $this->Connection->prepare('SELECT t.translation_id, t.language_id, t.translation FROM sc_translation_memory t LEFT JOIN sc_languages l ON t.language_id = l.language_id WHERE l.enabled_flag = 1 AND (t.translation_id LIKE :uppercase_needle OR t.translation LIKE :needle)');
        $stmt->bindParam(':uppercase_needle', $uppercase_needle, \PDO::PARAM_STR);
        $stmt->bindParam(':needle', $needle, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);

        if (is_array($result) && !empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Load translations as name/value pairs.
     *
     * @param string $language_code
     * @param bool $storefront
     * @return array
     */
    public function getTranslations($language_code = null, $storefront = true)
    {
        if ($language_code !== null) {
            $this->setLanguage($language_code);
        }

        $storefront = (bool)$storefront;

        // Populate with British English ('en-GB') as the root language
        if ($this->Translations === null || $this->LanguageID == 'en-GB') {
            $this->Translations = array();
            $this->readTranslations('en-GB', $storefront);
        }

        if ($this->LanguageID != 'en-GB') {
            if ($this->ParentLanguageID !== 'en-GB' && $this->ParentLanguageID !== $this->LanguageID) {
                $this->readTranslations($this->ParentLanguageID, $storefront);
            }
            $this->readTranslations($this->LanguageID, $storefront);
        }

        return $this->Translations;
    }

    /**
     * Read all translations for a given language.
     *
     * @param string $language_id
     * @param bool $storefront
     * @return void
     */
    private function readTranslations($language_id, $storefront)
    {
        $sql = 'SELECT translation_id, translation FROM sc_translation_memory WHERE language_id = :language_id';
        if ($storefront) {
            $sql .= ' AND admin_only_flag = 0';
        }
        $sql .= ' ORDER BY translation_id ASC';

        $stmt = $this->Connection->prepare($sql);
        $stmt->bindParam(':language_id', $language_id, \PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->Translations[$row['translation_id']] = $row['translation'];
        }
    }

    /**
     * Set the language to load.
     *
     * @param string $language_code
     *   Internal language identifier or ISO language code.
     *
     * @return bool
     *   Returns true if the language was set or false if the language does not
     *   exist or is not enabled.
     */
    public function setLanguage($language_code)
    {
        if (!is_string($language_code)) {
            return false;
        }

        if ($language_code == $this->LanguageID) {
            return true;
        }

        $language_code = str_ireplace('_', '-', $language_code);
        $sql = 'SELECT language_id, parent_id FROM sc_languages WHERE enabled_flag = 1 ';
        if (strlen($language_code) == 5) {
            $sql .= 'AND language_id = :language_code';
        } else {
            $language_code = strtolower($language_code);
            $language_code = $language_code . '%';
            $sql .= "AND language_id LIKE :language_code ORDER BY sort_order ASC, parent_id = 'en-GB' DESC LIMIT 1";
        }
        $stmt = $this->Connection->prepare($sql);
        $stmt->bindParam(':language_code', $language_code, \PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return false;
        } else {
            $this->LanguageID = $row['language_id'];
            $this->ParentLanguageID = $row['parent_id'];
            return true;
        }
    }

    /**
     * Add a new translation or update an existing translation.
     *
     * @param string $constant_name
     * @param string $language_id
     * @param string $translation
     * @param bool $admin_only
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setTranslation($constant_name, $language_id, $translation, $admin_only = false)
    {
        if (!is_string($constant_name) || !is_string($language_id) || !is_string($translation) ) {
            throw new \InvalidArgumentException();
        }

        $constant_name = trim($constant_name);
        $constant_name = strtoupper($constant_name);

        $translation = trim($translation);
        if (empty($translation)) {
            return;
        }

        if ($admin_only === true) {
            $admin_only_flag = 1;
        } else {
            $admin_only_flag = 0;
        }

        $stmt = $this->Connection->prepare('INSERT INTO sc_translation_memory (translation_id, language_id, translation, admin_only_flag) VALUES (:translation_id, :language_id, :translation, :admin_only_flag) ON DUPLICATE KEY UPDATE translation_id = :update_translation_id, language_id = :update_language_id, translation = :update_translation, admin_only_flag = :update_admin_only_flag');
        $stmt->bindValue(':translation_id', $constant_name, \PDO::PARAM_STR);
        $stmt->bindValue(':update_translation_id', $constant_name, \PDO::PARAM_STR);
        $stmt->bindValue(':language_id', $language_id, \PDO::PARAM_STR);
        $stmt->bindValue(':update_language_id', $language_id, \PDO::PARAM_STR);
        $stmt->bindValue(':translation', $translation, \PDO::PARAM_STR);
        $stmt->bindValue(':update_translation', $translation, \PDO::PARAM_STR);
        $stmt->bindValue(':admin_only_flag', $admin_only_flag, \PDO::PARAM_INT);
        $stmt->bindValue(':update_admin_only_flag', $admin_only_flag, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
