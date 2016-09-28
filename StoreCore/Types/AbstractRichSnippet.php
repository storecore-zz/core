<?php
namespace StoreCore\Types;

/**
 * Abstract Rich Snippet
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://developers.google.com/search/docs/guides/intro-structured-data
 * @version   0.1.0
 */
abstract class AbstractRichSnippet
{
    const VERSION = '0.1.0';

    /**
     * @var array $Data
     */
    protected $Data = array(
        '@context' => 'http://schema.org',
    );

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->Data, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @var array $SupportedTypes
     *   Array consisting of Schema.org types.  To allow for case-insensitive
     *   types, the lowercase keys point to the proper case values.  This array
     *   is replaced in derived classes if a type has more specific child types.
     */
    protected $SupportedTypes = array();

    /**
     * Get a JSON-LD script tag for HTML or AMP HTML.
     *
     * @param bool $pretty_print
     *
     * @return string
     *
     * @see https://search.google.com/structured-data/testing-tool
     *      Google Structured Data Testing Tool (SDTT)
     */
    public function getScript($pretty_print = false)
    {
        if ($pretty_print) {
            $eol = PHP_EOL;
            $json = json_encode($this->Data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } else {
            $eol = (string)null;
            $json = json_encode($this->Data, JSON_UNESCAPED_SLASHES);
        }

        $json = stripcslashes($json);
        $json = str_ireplace('":"{', '":{', $json);
        $json = str_ireplace('": "{', '": {' . $eol, $json);
        $json = str_ireplace('"}",', '"},' . $eol, $json);

        return
            '<script type="application/ld+json">' . $eol
            . $json . $eol
            . '<script>' . $eol;
    }


    /**
     * Generic property setter.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     * @throws \InvalidArgumentException
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
     * @param string $value
     * @return $this
     * @throws \InvalidArgumentException
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
