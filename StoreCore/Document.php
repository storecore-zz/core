<?php
namespace StoreCore;

/**
 * HTML5 Document with AMP Support
 *
 * @author    Ward van der Put <ward.vanderput@storecore.org>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Document
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
      * @var bool $AcceleratedMobilePage
      *   Create an AMP HTML document (true) or not (default false).
      */
    protected $AcceleratedMobilePage = false;

    /**
     * @var bool $jQuery
     *   Include the jQuery JavaScript library (true) or not (default false).
     */
    protected $jQuery = false;

    /**
     * @var string $Direction
     * @var string $Language
     * @var null|array $Links
     * @var null|array $MetaProperties
     * @var null|array $ScriptLinks
     * @var null|array $Scripts
     * @var null|array $ScriptsDeferred
     * @var array $Sections
     * @var string $Style
     * @var string $Title
     */
    protected $Direction = 'ltr';
    protected $Language = 'en-GB';
    protected $Links;
    protected $MetaProperties;
    protected $ScriptLinks;
    protected $Scripts;
    protected $ScriptsDeferred;
    protected $Sections = array();
    protected $Style = '';
    protected $Title;

    /** @var array $MetaData */
    protected $MetaData = array(
        'generator' => 'StoreCore',
        'rating' => 'general',
        'robots' => 'index,follow',
        'viewport' => 'width=device-width,initial-scale=1,minimum-scale=1',
        'apple-mobile-web-app-capable' => 'yes',
        'apple-mobile-web-app-status-bar-style' => 'black-translucent',
    );

    /**
     * Create an HTML document.
     *
     * @param string|null $title
     *   Title of the document to include in the HTML `<title>...</title>` tag.
     *
     * @return self
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
     * @uses getDocument()
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

        // MD5 hash key of the lowercase URL, where https:// ≡ http:// ≡ //
        $key = $href;
        $key = str_ireplace('https://', '//', $key);
        $key = str_ireplace('http://', '//', $key);
        $key = mb_strtolower($key, 'UTF-8');
        $key = md5($key);
        $this->Links[$key] = $link;

        return $this;
    }

    /**
     * Add meta data for a <meta name="..."  content="..."> tag.
     *
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
     * Add a link to an external client-side script.
     *
     * @param string $src
     *   Absolute or relative URL of the script source file for the `src`
     *   attribute in a `<script src="...">` tag.
     *
     * @param bool $defer
     *   Adds the `defer` attribute (default true) or omits it (false).
     *
     * @param bool $async
     *   Adds the `async` attribute (true) or omits it (default false).
     *   If the `$defer` and `$async` parameters are both set to true, the
     *   `$async` parameter is ignored (and the `async` attribute is reset
     *   to the default value false).
     *
     * @return $this
     */
    public function addScriptLink($src, $defer = true, $async = false)
    {
        $src = trim($src);
        $key = mb_strtolower($src, 'UTF-8');
        $key = md5($key);

        if ($defer == true) {
            $async = false;
        }

        $this->ScriptLinks[$key] = array(
            'src'   => $src,
            'defer' => $defer,
            'async' => $async,
        );

        return $this;
    }

    /**
     * Add a section to the document body.
     *
     * @param string $content
     *   Content for a new HTML container.  Please note that multiple sections
     *   are parsed and displayed in the order they are added.
     *
     * @param string|false|null $container
     *   Enclosing parent container for the new content.  Defaults to `section`
     *   for a generic `<section>...</section>` container.  This parameter MAY
     *   be set to null, to false or to an empty string if the parent container
     *   is to be omitted.
     *
     * @return $this
     */
    public function addSection($content, $container = 'section')
    {
        if (empty($container) || $container === false) {
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
     * Add internal (embedded) CSS code.
     *
     * @param string $css
     * @return $this
     */
    public function addStyle($css)
    {
        $css = strip_tags($css);
        $css = trim($css);
        $css = str_ireplace("\r\n", null, $css);
        $css = str_ireplace("\n", null, $css);
        $css = str_ireplace(' {', '{', $css);
        $css = str_ireplace('{ ', '{', $css);
        $css = str_ireplace('} ', '}', $css);
        $css = str_ireplace(': ', ':', $css);
        $css = str_ireplace('; ', ';', $css);
        $css = str_ireplace(';}', '}', $css);
        $this->Style .= $css;
        return $this;
    }

    /**
     * Enable AMP HTML.
     *
     * @param bool $use_amp_html
     *   Use Google AMP HTML for Accelerated Mobile Pages (default true) or not
     *   (false).
     *
     * @return void
     */
    public function amplify($use_amp_html = true)
    {
        $this->AcceleratedMobilePage = (bool)$use_amp_html;
    }

    /**
     * Get the document <body> container.
     *
     * @param void
     *
     * @return string
     *   Returns the `<body>...</body>` container as a string.
     */
    public function getBody()
    {
        return '<body>' . implode($this->Sections) . '</body>';
    }

    /**
     * Get the full HTML document.
     *
     * @param void
     *
     * @return string
     *   Returns the full `<html>...</html>` container with a `DOCTYPE`
     *   declaration as a string.
     *
     * @uses getBody()
     *
     * @uses getHead()
     */
    public function getDocument()
    {
        $html  = '<!DOCTYPE html>';

        $html .= '<html';
        if ($this->AcceleratedMobilePage) {
            $html .= ' amp';
        }
        $html .= ' dir="' . $this->Direction . '" lang="' . $this->Language . '">';

        $html .= $this->getHead();
        $html .= $this->getBody();

        /*
         * jQuery
         *
         * Load jQuery from Google CDN with a fallback for Microsoft Internet
         * Explorer (MSIE) <= 8.  If the CDN is not available, jQuery is loaded
         * from the local /js/ assets.
         *
         * @see https://code.jquery.com/
         * @see https://developers.google.com/speed/libraries/
         * @see https://www.asp.net/ajax/cdn#jQuery_Releases_on_the_CDN_0
         */
        if (!$this->AcceleratedMobilePage) {
            if ($this->jQuery) {
                if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(?i)msie [4-8]/', $_SERVER['HTTP_USER_AGENT'])) {
                    $html .= '<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>';
                    $html .= '<script>';
                    $html .= 'if (typeof jQuery == \'undefined\') { document.write(unescape("%3Cscript src=\'/js/jquery-1.12.4.min.js\' type=\'text/javascript\'%3E%3C/script%3E")); } ';
                    $html .= '</script>';
                } else {
                    $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
                    $html .= '<script>';
                    $html .= 'if (typeof jQuery == \'undefined\') { document.write(unescape("%3Cscript src=\'/js/jquery-3.1.1.min.js\' type=\'text/javascript\'%3E%3C/script%3E")); } ';
                    $html .= '</script>';
                }
            }

            if ($this->ScriptsDeferred !== null) {
                $html .= '<script>';
                $html .= implode($this->ScriptsDeferred);
                $html .= '</script>';
            }
        }

        $html .= '</html>';
        return $html;
    }

    /**
     * Get the document <head> container.
     *
     * @param void
     *
     * @return string
     *   Returns the `<head>...</head>` container as a string.
     */
    public function getHead()
    {
        $head  = '<head>';

        /*
         * In an AMP page the charset definition MUST be the first child of the
         * <head> tag and the AMP runtime MUST be loaded as the second child of
         * the <head> tag.  If this document is not an AMP page, the minified
         * JavaScript voor Material Design Lite (MDL) is loaded but deferred.
         */
        $head .= '<meta charset="utf-8">';
        if ($this->AcceleratedMobilePage) {
            $head .= '<script async src="https://cdn.ampproject.org/v0.js"></script>';
        } else {
            $head .= '<script defer src="/scripts/material.min.js"></script>';
        }

        if ($this->Title != null) {
            $head .= '<title>' . $this->Title . '</title>';
        }

        if ($this->Links !== null) {
            $links = (string)null;
            $dns_prefetch = false;
            foreach ($this->Links as $link) {
                $links .= '<link';
                foreach ($link as $attribute => $value) {
                    $links .= ' ' . $attribute . '="' . $value . '"';
                    if ($dns_prefetch === false && $attribute == 'rel' && $value == 'dns-prefetch') {
                        $dns_prefetch = true;
                    }
                }
                $links .= '>';
            }
            if ($dns_prefetch) {
                $head .= '<meta http-equiv="x-dns-prefetch-control" content="on">';
            }
            $head .= $links;
            unset($attribute, $dns_prefetch, $link, $links, $value);
        }

        if ($this->ScriptLinks !== null) {
            foreach ($this->ScriptLinks as $link) {
                if ($link['async'] === true) {
                    $head .= '<script async';
                } elseif ($link['defer'] === false) {
                    $head .= '<script';
                } else {
                    $head .= '<script defer';
                }
                $head .= ' src="' . $link['src'] . '"></script>';
            }
        }

        if (!empty($this->Style)) {
            if ($this->AcceleratedMobilePage) {
                $head .= '<style amp-custom>';
            } else {
                $head .= '<style>';
            }
            $head .= $this->Style;
            $head .= '</style>';
        }
        if ($this->AcceleratedMobilePage) {
            $head .= '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';
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
     * Enable or disable jQuery.
     *
     * @param bool $use_jquery
     *   Use the jQuery JavaScript library (default true) or not (false).
     *   By default jQuery is not included, so you must explicitly call
     *   `jquerify()` or `jquerify(true)` if a document needs to support
     *   jQuery JavaScript.
     *
     * @return void
     */
    public function jquerify($use_jquery = true)
    {
        $this->jQuery = (bool)$use_jquery;
    }

    /**
     * Add a document description.
     *
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
     * Set the theme color.
     *
     * @param string $color
     * @return $this
     */
    public function setThemeColor($color)
    {
        $this->addMetaData('msapplication-navbutton-color', $color);
        $this->addMetaData('theme-color', $color);
        return $this;
    }

    /**
     * Set the document title.
     *
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
