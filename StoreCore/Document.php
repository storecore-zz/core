<?php
namespace StoreCore;

/**
 * HTML5 Document
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   0.0.1
 */
class Document
{
    /**
     * @type string VERSION
     *     Semantic Version (SemVer)
     */
    const VERSION = '0.0.1';

    /**
     * @type string $Direction
     * @type string $Language
     * @type null|array $Links
     * @type null|array $MetaProperties
     * @type null|array $Scripts
     * @type null|array $ScriptsDeferred
     * @type array $Sections
     * @type string $Title
     */
    protected $Direction = 'ltr';
    protected $Language = 'en-GB';
    protected $Links;
    protected $MetaProperties;
    protected $Scripts;
    protected $ScriptsDeferred;
    protected $Sections = array();
    protected $Title = 'StoreCore';

    /**
     * @type array $MetaData
     */
    protected $MetaData = array(
        'robots' => 'index,follow',
        'viewport' => 'width=device-width, initial-scale=1',
    );

    /**
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
     * @return $this
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link
     */
    public function addLink($href, $rel = null, $type = null, $media = null)
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

        $this->Links[md5($href)] = $link;
        return $this;
    }

    /**
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
     * @param string $script
     * @param bool $defer
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
     * @param string $content
     * @param string $container
     * @return $this
     */
    public function addSection($content, $container = 'section')
    {
        $container = strtolower($container);

        $this->Sections[] = '<' . $container . '>' . $content . '</' . $container . '>';

        return $this;
    }

    /**
     * @param void
     * @return string
     */
    public function getBody()
    {
        $body  = '<body>';
        $body .= implode($this->Sections);
        $body .= '</body>';
        return $body;
    }
    /**
     * @param void
     * @return string
     */
    public function getDocument()
    {
        $html  = '<!DOCTYPE html>';
        $html .= '<html dir="' . $this->Direction . '" lang="' . $this->Language . '">';
        $html .= $this->getHead();
        $html .= $this->getBody();

        if ($this->ScriptsDeferred !== null) {
            $html .= '<script defer>';
            $html .= implode($this->ScriptsDeferred);
            $html .= '</script>';
        }

        $html .= '</html>';
        return $html;
    }

    /**
     * @param void
     * @return string
     */
    public function getHead()
    {
        $head  = '<head>';
        $head .= '<meta charset="UTF-8">';
        $head .= '<title>' . $this->Title . '</title>';

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
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $title = trim($title);
        $this->Title = $title;
        return $this;
    }
}
