<?php
namespace StoreCore\Types;

/**
 * Abstract Rich Snippet
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://developers.google.com/search/docs/guides/intro-structured-data
 * @version   0.1.0
 */
abstract class AbstractRichSnippet
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $Data
     *   Object properties as key/value pairs.
     */
    protected $Data = array(
        '@context' => 'http://schema.org',
    );

    /**
     * @var array $SupportedTypes
     *   Array consisting of Schema.org types.  To allow for case-insensitive
     *   types, the lowercase keys point to the proper case values.  This array
     *   is replaced in derived classes if a type has more specific child types.
     */
    protected $SupportedTypes = array();

    /**
     * Generic property getter.
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get($name) {
        if (array_key_exists($name, $this->Data)) {
            return $this->Data[$name];
        } else {
            return null;
        }
    }

    /**
     * Convert the data object to a JSON encoded string.
     *
     * @param void
     *
     * @return string
     *   Returns a JSON encoded multidimensional array as a string.
     *   Use the `getScript()` method for a similar HTML snippet in JSON-LD.
     */
    public function __toString()
    {
        $data = $this->getDataArray();
        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get the object data as an array.
     *
     * @param void
     *
     * @return array
     *   Returns all object data as a multidimensional array.
     */
    public function getDataArray()
    {
        $data = array();
        foreach ($this->Data as $key => $value) {
            if (is_object($value)) {
                $value = $value->getDataArray();
            }
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * Get a JSON-LD script tag for HTML or AMP HTML.
     *
     * @param void
     *
     * @return string
     *   Returns the data object as a string in JavaScript Object Notation
     *   for Linked Data (JSON-LD) within the HTML5 and AMP HTML script tag
     *   `<script type="application/ld+json">…</script>`.
     *
     * @see https://search.google.com/structured-data/testing-tool
     *      Google Structured Data Testing Tool (SDTT)
     */
    public function getScript()
    {
        $json = json_encode($this->getDataArray(), JSON_UNESCAPED_SLASHES);
        $json = stripcslashes($json);
        $json = str_ireplace('":"{', '":{', $json);
        $json = str_ireplace('"}",', '"},', $json);
        $json = str_ireplace('}"}', '}}', $json);
        $json = str_ireplace('}}","', '}},"', $json);

        return
            '<script type="application/ld+json">' . PHP_EOL
            . $json . PHP_EOL
            . '</script>';
    }

    /**
     * Generic date property setter.
     *
     * @param string $name
     *
     * @param DateTime|string $date
     *   Date value as a DateTime object or a string in the ISO 8601 date
     *   format yyyy-mm-dd (the PHP date format 'Y-m-d').
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$date` parameter is not
     *   a valid date.
     */
    public function setDateProperty($name, $date)
    {
        if ($date instanceof DateTime) {
            $date = $date->format('Y-m-d');
        }

        if (is_string($date)) {
            $date = trim($date);
            if (strlen($date) !== 10) {
                throw new \InvalidArgumentException();
            } else {
                $parsed_date = date_parse($date);
                if (
                    $parsed_date === false
                    || checkdate($parsed_date['month'], $parsed_date['day'], $parsed_date['year']) === false
                ) {
                    throw new \InvalidArgumentException();
                } else {
                    $this->setStringProperty($name, $date);
                }
            }
        } else {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    /**
     * Generic property setter.
     *
     * @param string $name
     *   Name of the property as a string.
     *
     * @param mixed $value
     *   Value of the property.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$name` parameter is not
     *   a string or an empty string.  The `$type` property is not checked;
     *   this MAY be implemented in classes that extend this abstract class.
     *   Use the `setStringProperty()` method if the `$value` must be a string.
     */
    public function setProperty($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException();
        }

        $name = trim($name);
        if (empty($name)) {
            throw new \InvalidArgumentException();
        }

        if ($value === true) {
            $value = 'http://schema.org/True';
        } elseif ($value === false) {
            $value = 'http://schema.org/False';
        }

        $this->Data[$name] = $value;
        return $this;
    }

    /**
     * Generic string property setter.
     *
     * @param string $name
     *   Name of the property as a string.
     *
     * @param string $value
     *   Value of the property as a string.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$value` is not a string
     *   or an empty string.
     */
    public function setStringProperty($name, $value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException();
        }

        $value = trim($value);
        if (empty($value)) {
            throw new \InvalidArgumentException();
        }

        $this->Data[$name] = $value;
        return $this;
    }

    /**
     * Set the data object type.
     *
     * @param string $type
     *   One of the supported Schema.org types.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the $type parameter is
     *   not a string.
     *
     * @throws \DomainException
     *   Throws a domain exception if the `$type` parameter is not one of the
     *   supported classes or subclasses.
     */
    public function setType($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException();
        }

        $type = trim($type);
        $type = strtolower($type);
        if (array_key_exists($type, $this->SupportedTypes) ) {
            $this->Data['@type'] = $this->SupportedTypes[$type];
        } else {
            throw new \DomainException();
        }
    }
}
