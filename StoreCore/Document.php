<?php
namespace StoreCore;

/**
 * HTML5 Document
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Document
{
    /**
     * @var string VERSION
     *   Semantic version (SemVer)
     */
    const VERSION = '0.1.0';

    /**
     * @var string $Direction
     * @var string $Language
     * @var null|array $Links
     * @var null|array $MetaProperties
     * @var null|array $Scripts
     * @var null|array $ScriptsDeferred
     * @var array $Sections
     * @var string $Title
     */
    protected $Direction = 'ltr';
    protected $Language = 'en-GB';
    protected $Links;
    protected $MetaProperties;
    protected $Scripts;
    protected $ScriptsDeferred;
    protected $Sections = array();
    protected $Title;

    /**
     * @var array $MetaData
     */
    protected $MetaData = array(
        'generator' => 'StoreCore ' . \StoreCore\VERSION,
        'rating' => 'general',
        'robots' => 'index,follow',
        'viewport' => 'width=device-width, initial-scale=1',
    );

    /**
     * @api
     * @param string $title
     * @return void
     */
    public function __construct($title = null)
    {
        if ($title !== null) {
            $this->setTitle($title);
        }
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return $this->getDocument();
    }

    /**
     * @param string $href
     * @param string $rel
     * @param string $type
     * @param string $media
     * @param string $hreflang
     * @return $this
     *
     * @see http://www.w3.org/TR/html5/links.html
     * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link
     */
    public function addLink($href, $rel = null, $type = null, $media = null, $hreflang = null)
    {
        $href = str_ireplace('https://', '//', $href);
        $href = str_ireplace('http://', '//', $href);
        $link = array('href' => $href);

        if ($rel !== null) {
            $rel = strtolower($rel);
            $link['rel'] = $rel;
        }

        if ($type !== null) {
            $type = strtolower($type);
            $link['type'] = $type;
        }

        if ($media !== null) {
            $media = strtolower($media);
            $link['media'] = $media;
        }

        if ($hreflang !== null) {
            $link['hreflang'] = $hreflang;
        }

        $this->Links[md5($href)] = $link;
        return $this;
    }

    /**
     * Add meta data for a <meta name="..."  content="..."> tag.
     *
     * @api
     * @param string $name
     * @param string $content
     * @return $this
     */
    public function addMetaData($name, $content)
    {
        $name = trim($name);
        $name = strtolower($name);
        $this->MetaData[$name] = $content;
        return $this;
    }

    /**
     * Add meta property data for a <meta property="..." content="..."> tag.
     *
     * @api
     * @param string $property
     * @param string $content
     * @return $this
     */
    public function addMetaProperty($property, $content)
    {
        $name = trim($property);
        $name = strtolower($property);
        $this->MetaProperties[$property] = $content;
        return $this;
    }

    /**
     * Add inline JavaScript.
     *
     * @param string $script
     *   Inline JavaScript, without the enclosing <script>...</script> tags.
     *
     * @param bool $defer
     *   If set to true (default), JavaScript execution is deferred by moving
     *   the script to the end of the HTML document.  This RECOMMENDED setting
     *   usually speeds op client-side page rendering.
     *
     * @return $this
     */
    public function addScript($script, $defer = true)
    {
        if ($defer !== false) {
            $this->ScriptsDeferred[] = $script;
        } else {
            $this->Scripts[] = $script;
        }
        return $this;
    }

    /**
     * Add a section to the document body.
     *
     * @param string $content
     *   Content for a new HTML container.  Please note that multiple sections
     *   are parsed and displayed in the order they are added.
     *
     * @param string|null $container
     *   Enclosing parent container for the new content.  Defaults to `section`
     *   for a generic `<section>...</section>` container.  This parameter MAY
     *   be set to null or an empty string if the parent container is to be
     *   omitted.
     *
     * @return $this
     */
    public function addSection($content, $container = 'section')
    {
        if (empty($container)) {
            $container = null;
        } else {
            $container = trim($container);
            $container = strtolower($container);
            $container = ltrim($container, '<');
            $container = rtrim($container, '>');
        }

        if ($container === null) {
            $this->Sections[] = $content;
        } else {
            $this->Sections[] = '<' . $container . '>' . $content . '</' . $container . '>';
        }

        return $this;
    }

    /**
     * Get the document <body>...</body> container.
     *
     * @api
     * @param void
     * @return string
     */
    public function getBody()
    {
        return
            '<body><div id="wrapper">' .
            implode($this->Sections) .
            '</div></body>';
    }

    /**
     * Get the full HTML document.
     *
     * @param void
     * @return string
     * @uses \StoreCore\Document::getBody()
     * @uses \StoreCore\Document::getHead()
     */
    public function getDocument()
    {
        $html  = '<!DOCTYPE html>';
        $html .= '<html dir="' . $this->Direction . '" lang="' . $this->Language . '">';
        $html .= $this->getHead();
        $html .= $this->getBody();

        if ($this->ScriptsDeferred !== null) {
            $html .= '<script>';
            $html .= implode($this->ScriptsDeferred);
            $html .= '</script>';
        }

        $html .= '</html>';
        return $html;
    }

    /**
     * Get the document <head>...</head> container.
     *
     * @api
     * @param void
     * @return string
     */
    public function getHead()
    {
        $head  = '<head>';
        $head .= '<meta charset="UTF-8">';
        
        if ($this->Title != null) {
            $head .= '<title>' . $this->Title . '</title>';
        }

        if ($this->Links !== null) {
            foreach ($this->Links as $link) {
                $head .= '<link';
                foreach ($link as $attribute => $value) {
                    $head .= ' ' . $attribute . '="' . $value . '"';
                }
                $head .= '>';
            }
        }

        foreach ($this->MetaData as $name => $content) {
            $head .= '<meta name="' . $name . '" content="' . $content . '">';
        }

        if ($this->MetaProperties !== null) {
            foreach ($this->MetaProperties as $property => $content) {
                $head .= '<meta property="' . $property . '" content="' . $content . '">';
            }
        }

        if ($this->Scripts !== null) {
            $head .= '<script>';
            $head .= implode($this->Scripts);
            $head .= '</script>';
        }

        $head .= '</head>';
        return $head;
    }

    /**
     * Add a document description.
     *
     * @api
     * @param string $description
     * @return $this
     * @uses \StoreCore\Document::addMetaData()
     */
    public function setDescription($description)
    {
        $description = trim($description);
        $this->addMetaData('description', $description);
        return $this;
    }

    /**
     * Set the document language.
     *
     * @param string $language_code
     * @return $this
     */
    public function setLanguage($language_code)
    {
        $language_code = str_ireplace('_', '-', $language_code);
        $language_codes = explode('-', $language_code);
        if (count($language_codes) === 2) {
            $language_code = strtolower($language_codes[0]) . '-' . strtoupper($language_codes[1]);
        }
        $this->Language = $language_code;
        return $this;
    }

    /**
     * Set the document title.
     *
     * @api
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $title = trim($title);
        $this->Title = $title;
        $this->addMetaProperty('og:title', $title);
        return $this;
    }
}
