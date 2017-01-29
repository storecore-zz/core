<?php
namespace StoreCore\Types;

/**
 * Schema.org Contact Point
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/ContactPoint
 * @version   0.1.0
 */
class ContactPoint extends StructuredValue
{
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
     * @return $this
     */
    public function setEmail($email)
    {
        if ($email instanceof EmailAddress) {
            $email = (string)$email;
        }
        $this->setStringProperty('email', $email);
        return $this;
    }

    /**
     * Set a fax number.
     *
     * @param string $fax_number
     * @return $this
     */
    public function setFaxNumber($fax_number)
    {
        $this->setStringProperty('faxNumber', $fax_number);
        return $this;
    }

    /**
     * Set the telephone number.
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->setStringProperty('telephone', $telephone);
        return $this;
    }
}
