<?php
namespace StoreCore;

/**
 * Person Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2016-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CRM
 * @version   0.1.0
 */
class Person extends AbstractSubject
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string|null $AdditionalName
     * @var bool        $AnonymizedFlag
     * @var string|null $BirthDate
     * @var string|null $BirthPlace
     * @var string|null $DateCreated
     * @var string|null $DateModified
     * @var bool        $DeletedFlag
     * @var string|null $DeathDate
     * @var string|null $DeathPlace
     * @var string|null $EmailAddress
     * @var string|null $FamilyName
     * @var string|null $FullName
     * @var string|null $FullNameInitials
     * @var int         $Gender
     * @var string|null $GivenName
     * @var string|null $GivenNameInitials
     * @var string|null $HonorificPrefix
     * @var string|null $HonorificSuffix
     * @var string|null $MiddleNameInitials
     * @var string|null $Nationality
     * @var int|null    $PersonID
     * @var string|null $TelephoneNumber
     */
    private $AdditionalName;
    private $AnonymizedFlag = false;
    private $BirthDate;
    private $BirthPlace;
    private $DateCreated;
    private $DateModified;
    private $DeathDate;
    private $DeletedFlag = false;
    private $DeathPlace;
    private $EmailAddress;
    private $FamilyName;
    private $FullName;
    private $FullNameInitials;
    private $Gender = 0;
    private $GivenName;
    private $GivenNameInitials;
    private $HonorificPrefix;
    private $HonorificSuffix;
    private $MiddleNameInitials;
    private $Nationality;
    private $PersonID;
    private $TelephoneNumber;

    /**
     * Anonymize PII (personally identifiable information).
     *
     * @param void
     * @return void
     */
    public function anonymize()
    {
        $this->AdditionalName = null;
        $this->BirthPlace = null;
        $this->DeathPlace = null;
        $this->EmailAddress = null;
        $this->FullName = null;
        $this->FullNameInitials = null;
        $this->GivenNameInitials = null;
        $this->HonorificPrefix = null;
        $this->HonorificSuffix = null;
        $this->MiddleNameInitials = null;
        $this->Nationality = null;
        $this->TelephoneNumber = null;

        // Abbreviate the family name (last name).
        if ($this->FamilyName !== null) {
            mb_internal_encoding('UTF-8');
            $abbreviated_family_name = array();
            $family_name = explode(' ', $this->FamilyName);
            foreach ($family_name as $word) {
                if ($word == mb_strtolower($word)) {
                    $abbreviated_family_name[] = $word;
                } else {
                    $abbreviated_family_name[] = mb_strtoupper(mb_substr($word, 0, 1)) . '.';
                    break;
                }
            }
            $this->FamilyName = implode(' ', $abbreviated_family_name);
        }

        // Shorten a birth date to month and year without the day (to allow
        // for analytics) and shorten a death date to just the year.
        if ($this->BirthDate !== null) {
            $this->BirthDate = substr($this->BirthDate, 0, 8) . '00';
        }
        if ($this->DeathDate !== null) {
            $this->DeathDate = substr($this->DeathDate, 0, 5) . '00-00';
        }

        $this->AnonymizedFlag = true;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getAdditionalName()
    {
        return $this->AdditionalName;
    }

    /**
     * @param void
     * @return bool
     */
    public function getAnonymizedFlag()
    {
        return $this->AnonymizedFlag;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getBirthDate()
    {
        return $this->BirthDate;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getBirthPlace()
    {
        return $this->BirthPlace;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getDateCreated()
    {
        return $this->DateCreated;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getDeathDate()
    {
        return $this->DeathDate;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getDeathPlace()
    {
        return $this->DeathPlace;
    }

    /**
     * @param void
     * @return bool
     */
    public function getDeletedFlag()
    {
        return $this->DeletedFlag;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getFamilyName()
    {
        return $this->FamilyName;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getFullName()
    {
        return $this->FullName;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getFullNameInitials()
    {
        return $this->FullNameInitials;
    }

    /**
     * Get the gender.
     *
     * @param void
     *
     * @return int
     *   Returns the ISO/IEC 5218 gender code 0 for not known, 1 for male,
     *   or 2 for female.  Defaults to 0 if the gender was not set.  Because
     *   the formal ISO/IEC gender codes are not always obvious, you MAY also
     *   use the isFemale() and isMale() class methods to test for a specific
     *   gender.
     */
    public function getGender()
    {
        return $this->Gender;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getGivenName()
    {
        return $this->GivenName;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getGivenNameInitials()
    {
        return $this->GivenNameInitials;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getHonorificPrefix()
    {
        return $this->HonorificPrefix;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getHonorificSuffix()
    {
        return $this->HonorificSuffix;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getMiddleNameInitials()
    {
        return $this->MiddleNameInitials;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getNationality()
    {
        return $this->Nationality;
    }

    /**
     * Get the person identifier (primary key).
     *
     * @param void
     * @return int|null
     */
    public function getPersonID()
    {
        return $this->PersonID;
    }

    /**
     * @param void
     * @return string|null
     */
    public function getTelephoneNumber()
    {
        return $this->TelephoneNumber;
    }

    /**
     * Check if the person is female.
     *
     * @param void
     * @return bool
     * @uses getGender()
     */
    public function isFemale()
    {
        return ($this->getGender() == 2) ? true : false;
    }

    /**
     * Check if the person is male.
     *
     * @param void
     * @return bool
     * @uses getGender()
     */
    public function isMale()
    {
        return ($this->getGender() == 1) ? true : false;
    }

    /**
     * @param string $additional_name
     * @return void
     */
    public function setAdditionalName($additional_name)
    {
        $this->AdditionalName = $additional_name;
    }

    /**
     * @param mixed $anonymized_flag
     * @return void
     */
    public function setAnonymizedFlag($anonymized_flag)
    {
        $this->AnonymizedFlag = (bool)$anonymized_flag;
    }

    /**
     * Set a partial or full date of birth.
     *
     * @param string|int $birth_date
     *   Date of birth in the ISO and MySQL 'YYYY-MM-DD' string format.  If the
     *   exact date is unknown, this date may be set using 'YYYY-MM' for a year
     *   with a month or 'YYYY' for just the year.
     *
     * @return void
     */
    public function setBirthDate($birth_date)
    {
        // Extend a year to the MySQL '####-00-00' date format
        // and a year plus month to ''####-##-00''.
        if (strlen($birth_date) == 4 && is_numeric($birth_date)) {
            $birth_date .= '-00-00';
        } elseif (strlen($birth_date) == 7) {
            $birth_date .= '-00';
        }

        $this->BirthDate = $birth_date;
    }

    /**
     * @param string $birth_place
     * @return void
     */
    public function setBirthPlace($birth_place)
    {
        $this->BirthPlace = $birth_place;
    }

    /**
     * @param string $date_created
     * @return void
     */
    public function setDateCreated($date_created)
    {
        $this->DateCreated = $date_created;
    }

    /**
     * Set the date and time of the last data update.
     *
     * @param string|null $date_modified
     *   UTC timestamp or null for the current date and time.
     *
     * @return void
     *
     * @uses \StoreCore\AbstractSubject::notify()
     *   Notifies observers if the new timestamp is different from a previously
     *   set timestamp, assuming that this indicates the person's data MAY have
     *   changed.
     */
    public function setDateModified($date_modified = null)
    {
        if ($date_modified === null) {
            $date_modified = gmdate('Y-m-d h:m:s');
        }

        if ($this->DateModified !== null && $date_modified !== $this->DateModified) {
            $this->DateModified = $date_modified;
            $this->notify();
        } else {
            $this->DateModified = $date_modified;
        }
    }

    /**
     * Set the person's date, month or year of death.
     *
     * @param string|int $death_date
     *   A full date 'YYYY-MM-DD' in the ISO and MySQL format, or 'YYYY-MM' or
     *   'YYYY' for a partial date.  In many business use cases the exact death
     *   date of a customer or other business contact may not be known.  This
     *   method allows setting an approximate date with only a year and month
     *   or just a year.
     *
     * @return void
     */
    public function setDeathDate($death_date)
    {
        if (strlen($death_date) == 4 && is_numeric($death_date)) {
            $death_date .= '-00-00';
        } elseif (strlen($death_date) == 7) {
            $death_date .= '-00';
        }
        $this->DeathDate = $death_date;
    }

    /**
     * @param string $death_place
     * @return void
     */
    public function setDeathPlace($death_place)
    {
        $this->DeathPlace = $death_place;
    }

    /**
     * @param mixed $deleted_flag
     * @return void
     */
    public function setDeletedFlag($deleted_flag)
    {
        $this->DeletedFlag = (bool)$deleted_flag;
    }

    /**
     * Set the person's e-mail address.
     *
     * @param string $email_address
     * @return void
     * @uses \StoreCore\AbstractSubject::notify()
     */
    public function setEmailAddress($email_address)
    {
        $this->EmailAddress = $email_address;
        $this->notify();
    }

    /**
     * @param string $family_name
     * @return void
     */
    public function setFamilyName($family_name)
    {
        $this->FamilyName = $family_name;
    }

    /**
     * @param string $full_name
     * @return void
     */
    public function setFullName($full_name)
    {
        $this->FullName = $full_name;
    }

    /**
     * @param string $full_name_initials
     * @return void
     */
    public function setFullNameInitials($full_name_initials)
    {
        $this->FullNameInitials = $full_name_initials;
    }

    /**
     * Set the gender.
     *
     * @param int|string
     * @return void
     * @see http://standards.iso.org/ittf/PubliclyAvailableStandards/c036266_ISO_IEC_5218_2004(E_F).zip
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function setGender($gender)
    {
        if (is_numeric($gender)) {
            $gender = (int)$gender;
            if ($gender < 0 || $gender > 2) {
                throw new \DomainException();
            } else {
                $this->Gender = $gender;
                return;
            }
        }

        if (!is_string($gender) || empty($gender)) {
            throw new \InvalidArgumentException();
        }

        $map = array(
            'desconocido' => 0,
            'f' => 2,
            'female' => 2,
            'feminin' => 2,
            'féminin' => 2,
            'femenino' => 2,
            'inconnu' => 0,
            'm' => 1,
            'male' => 1,
            'man' => 1,
            'mannelijk' => 1,
            'mannlich' => 1,
            'männlich' => 1,
            'masculin' => 1,
            'masculino' => 1,
            'not known' => 0,
            'onbekend' => 0,
            'unbekannt' => 0,
            'unknown' => 0,
            'v' => 2,
            'vrouw' => 2,
            'vrouwelijk' => 2,
            'weiblich' => 2,
        );
        $gender = mb_strtolower($gender, 'UTF-8');
        if (array_key_exists($gender, $map)) {
            $this->Gender = $map[$gender];
        } else {
            throw new \OutOfRangeException();
        }
    }

    /**
     * @param string $given_name
     * @return void
     */
    public function setGivenName($given_name)
    {
        $this->GivenName = $given_name;
    }

    /**
     * @param string $given_name_initials
     * @return void
     */
    public function setGivenNameInitials($given_name_initials)
    {
        $this->GivenNameInitials = $given_name_initials;
    }

    /**
     * @param string $honorific_prefix
     * @return void
     */
    public function setHonorificPrefix($honorific_prefix)
    {
        $this->HonorificPrefix = $honorific_prefix;
    }

    /**
     * @param string $honorific_suffix
     * @return void
     */
    public function setHonorificSuffix($honorific_suffix)
    {
        $this->HonorificSuffix = $honorific_suffix;
    }

    /**
     * @param string $middle_name_initials
     * @return void
     */
    public function setMiddleNameInitials($middle_name_initials)
    {
        $this->MiddleNameInitials = $middle_name_initials;
    }

    /**
     * Set a nationality.
     *
     * @param string $nationality
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setNationality($nationality)
    {
        if (!is_string($nationality)) {
            throw new \InvalidArgumentException();
        }
        $nationality = trim($nationality);
        $nationality = strtoupper($nationality);
        if (strlen($nationality) === 2 && ctype_upper($nationality)) {
            $this->Nationality = $nationality;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * Set the person identifier.
     *
     * @param int $person_id
     * @return void
     */
    public function setPersonID($person_id)
    {
        $this->PersonID = (int)$person_id;
    }

    /**
     * Set the person's (personal) phone number.
     *
     * @param string $telephone_number
     * @return void
     * @uses \StoreCore\AbstractSubject::notify()
     */
    public function setTelephoneNumber($telephone_number)
    {
        $this->TelephoneNumber = $telephone_number;
        $this->notify();
    }
}
