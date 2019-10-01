<?php
namespace StoreCore\Types;

/**
 * Schema.org Contact Point
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/ContactPoint
 * @version   0.1.0
 */
class ContactPoint extends StructuredValue
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
        'contactpoint' => 'ContactPoint',
        'postaladdress' => 'PostalAddress',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('ContactPoint');
    }

    /**
     * Set an e-mail address.
     *
     * @param EmailAddress|string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        if ($email instanceof EmailAddress) {
            $email = (string)$email;
        }
        $this->setStringProperty('email', $email);
    }

    /**
     * Set a fax number.
     *
     * @param string $fax_number
     *
     * @return void
     */
    public function setFaxNumber($fax_number)
    {
        $this->setStringProperty('faxNumber', $fax_number);
    }

    /**
     * Set the telephone number.
     *
     * @param string $telephone
     *
     * @return void
     */
    public function setTelephone($telephone)
    {
        $this->setStringProperty('telephone', $telephone);
    }
}
