<?php
namespace StoreCore\Database;

/**
 * Person Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CRM
 * @version   0.1.0
 */
class PersonMapper extends AbstractDataAccessObject
{
    const VERSION = '0.1.0';

    const TABLE_NAME  = 'sc_persons';
    const PRIMARY_KEY = 'person_id';

    /**
     * Anonymize PII (personally identifiable information).
     *
     * @param \StoreCore\Database\Person $person
     * @return bool
     */
    public function anonymize(\StoreCore\Database\Person $person)
    {
        $person_id = $person->getPersonID();

        // Nothing to do on an unknown person
        if ($person_id == null) {
            return false;
        }

        try {
            // Revoke an API or admin user account for an anonymized user.
            $stmt = $this->Connection->prepare('
                UPDATE sc_users
                   SET user_group_id = 0,
                       person_id = NULL,
                       email_address = NULL
                 WHERE person_id = :person_id
            ');
            $stmt->bindValue(':person_id', $person_id, \PDO::PARAM_INT);
            $stmt->execute();

            // Delete associations with organizations.
            $stmt = $this->Connection->prepare('
                DELETE
                  FROM sc_person_organizations
                 WHERE person_id = :person_id
            ');
            $stmt->bindValue(':person_id', $person_id, \PDO::PARAM_INT);
            $stmt->execute();

            // Delete associations with addresses.
            $stmt = $this->Connection->prepare('
                DELETE
                  FROM sc_person_addresses
                 WHERE person_id = :person_id
            ');
            $stmt->bindValue(':person_id', $person_id, \PDO::PARAM_INT);
            $stmt->execute();

            // Delete most personal data.
            $person->anonymize();
            $stmt = $this->Connection->prepare('
                UPDATE sc_persons
                   SET honorific_prefix = NULL,
                       additional_name = NULL,
                       honorific_suffix = NULL,
                       full_name = NULL,
                       given_name_initials = NULL,
                       middle_name_initials = NULL,
                       full_name_initials = NULL,
                       email_address = NULL,
                       telephone_number = NULL,
                       fax_number = NULL,
                       birth_place = NULL,
                       death_place = NULL,
                       date_anonymized = UTC_TIMESTAMP()
                 WHERE person_id = :person_id
            ');
            $stmt->bindParam(':person_id', $person_id, \PDO::PARAM_INT);
            $stmt->execute();

            $stmt->closeCursor();
            return true;

        } catch (\PDOException $e) {

            $this->Logger->error($e->getMessage());
            return false;

        }
    }

    /**
     * Get a person by the unique person ID.
     *
     * @param int $person_id
     * @return \StoreCore\Person|null
     */
    public function getPerson($person_id)
    {
        $data = $this->read($person_id);
        if (is_array($data) && count($data) === 1) {
            return $this->getPersonObject($data[0]);
        } else {
            return null;
        }
    }

    /**
     * Map the person's data to a person object.
     *
     * @param array $keyed_data
     * @return \StoreCore\Person
     */
    private function getPersonObject(array $keyed_data)
    {
        if (!array_key_exists(self::PRIMARY_KEY, $keyed_data)) {
            return null;
        }

        $person = new \StoreCore\Person();

        $person->setPersonID($keyed_data['person_id']);
        $person->setEmailAddress($keyed_data['email_address']);

        $person->setAnonymizedFlag($keyed_data['anonymized_flag']);
        $person->setDeletedFlag($keyed_data['deleted_flag']);
        $person->setDateCreated($keyed_data['date_created']);
        $person->setDateModified($keyed_data['date_modified']);

        $person->setGender($keyed_data['gender']);
        $person->setHonorificPrefix($keyed_data['honorific_prefix']);
        $person->setGivenName($keyed_data['given_name']);
        $person->setAdditionalName($keyed_data['additional_name']);
        $person->setFamilyName($keyed_data['family_name']);
        $person->setHonorificSuffix($keyed_data['honorific_suffix']);
        $person->setFullName($keyed_data['full_name']);
        $person->setGivenNameInitials($keyed_data['given_name_initials']);
        $person->setMiddleNameInitials($keyed_data['middle_name_initials']);
        $person->setFullNameInitials($keyed_data['full_name_initials']);
        $person->setTelephoneNumber($keyed_data['telephone_number']);

        if ($keyed_data['nationality'] !== null) {
            $person->setNationality($keyed_data['nationality']);
        }

        $person->setBirthDate($keyed_data['birth_date']);
        $person->setBirthPlace($keyed_data['birth_place']);
        $person->setDeathDate($keyed_data['birth_place']);
        $person->setDeathPlace($keyed_data['death_place']);

        return $person;
    }

    /**
     * Save a person to the database.
     *
     * @param \StoreCore\Person $person
     * @return mixed
     * @uses \StoreCore\AbstractSubject::notify()
     */
    public function save(\StoreCore\Person &$person)
    {
        $person_data = array();

        $person_data['anonymized_flag'] = $person->getAnonymizedFlag();
        $person_data['deleted_flag'] = $person->getDeletedFlag();

        $person_data['email_address'] = $person->getEmailAddress();
        $person_data['gender'] = $person->getGender();
        $person_data['honorific_prefix'] = $person->getHonorificPrefix();
        $person_data['given_name'] = $person->getGivenName();
        $person_data['additional_name'] = $person->getAdditionalName();
        $person_data['family_name'] = $person->getFamilyName();
        $person_data['honorific_suffix'] = $person->getHonorificSuffix();
        $person_data['full_name'] = $person->getFullName();
        $person_data['given_name_initials'] = $person->getGivenNameInitials();
        $person_data['middle_name_initials'] = $person->getMiddleNameInitials();
        $person_data['full_name_initials'] = $person->getFullNameInitials();
        $person_data['full_name_initials'] = $person->getFullNameInitials();
        $person_data['telephone_number'] = $person->getTelephoneNumber();
        $person_data['nationality'] = $person->getNationality();
        $person_data['birth_date'] = $person->getBirthDate();
        $person_data['birth_place'] = $person->getBirthPlace();
        $person_data['death_date'] = $person->getDeathDate();
        $person_data['death_place'] = $person->getDeathPlace();

        if ($person->getPersonID() === null) {
            $current_date = gmdate('Y-m-d');
            $person_data['date_created'] = $current_date;
            $person->setDateCreated($current_date);
            $return = $this->create($person_data);
            if (is_numeric($return)) {
                $person->setPersonID($return);
            }
        } else {
            $person_data[self::PRIMARY_KEY] = $person->getPersonID();
            $return = $this->update($person_data);
        }

        // Notify all observers of persisted changes.
        if ($return !== false) {
            $person->notify();
        }

        return $return;
    }
}
