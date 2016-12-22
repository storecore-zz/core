<?php
namespace StoreCore\StoreFront;

/**
 * Google Measurement Protocol Hit
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @see       https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 * @uses      \StoreCore\Types\ClientID
 * @version   0.1.0
 */
class GoogleAnalyticsHit
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string  HIT_TYPE_EXCEPTION   t=exception
     * @var string  HIT_TYPE_EVENT       t=event
     * @var string  HIT_TYPE_ITEM        t=item
     * @var string  HIT_TYPE_PAGEVIEW    t=pageview (default)
     * @var string  HIT_TYPE_SCREENVIEW  t=screenview
     * @var string  HIT_TYPE_SOCIAL      t=social
     * @var string  HIT_TYPE_TIMING      t=timing
     * @var string  HIT_TYPE_TRANSACTION t=transaction
     */
    const HIT_TYPE_EXCEPTION   = 'exception';
    const HIT_TYPE_EVENT       = 'event';
    const HIT_TYPE_ITEM        = 'item';
    const HIT_TYPE_PAGEVIEW    = 'pageview';
    const HIT_TYPE_SCREENVIEW  = 'screenview';
    const HIT_TYPE_SOCIAL      = 'social';
    const HIT_TYPE_TIMING      = 'timing';
    const HIT_TYPE_TRANSACTION = 'transaction';

    /** @var bool $AnonymizeIP */
    private $AnonymizeIP = true;

    /** @var array $Data */
    protected $Data = array(
        'v'  => 1,          // version
        't'  => 'pageview', // hit type
        'ds' => 'web',      // data source (optional)
    );

    /**
     * @var array $CustomDimensions Indexed array cd<dimensionIndex>=<string>
     * @var array $CustomMetrics    Indexed array cm<metricIndex>=<float|int>
     */
    protected $CustomDimensions = array();
    protected $CustomMetrics = array();

    /** @var bool $Debug */
    private $Debug = false;

    /** @var array $RequiredParameters */
    private $RequiredParameters = array(
        'v',   // version
        't',   // hit type
        'tid', // tracking ID
        'cid', // client ID
    );

    /**
     * @param void
     * @return self
     */
    public function __construct()
    {
        /*
         * For 'pageview' hits, either 'dl' (document location) or both
         * 'dh' (document host) and 'dp' (document path) have to be specified
         * for the hit to be valid.
         */
        if (!empty($_SERVER['HTTP_HOST'])) {
            $this->setDocumentHostname($_SERVER['HTTP_HOST']);
        }
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->setDocumentPath($_SERVER['REQUEST_URI']);
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $this->setDocumentReferrer($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Anonymize the client IP address.
     *
     * @param bool $anonymize_ip
     *   Anonymize (default true) or publish (false) the client IP address.
     *
     * @return $this
     */
    public function anonymizeIP($anonymize_ip = true)
    {
        $this->AnonymizeIP = (bool)$anonymize_ip;
        return $this;
    }

    /**
     * Post the hit to Google.
     *
     * @param void
     *
     * @return true|string
     *   Returns true on success or a payload string on failure.
     */
    public function collect()
    {
        if ($this->AnonymizeIP) {
            $this->Data['aip'] = 1;
        } else {
            unset($this->Data['aip']);
        }

        // Add custom dimensions (cd).
        if (!empty($this->CustomDimensions)) {
            foreach ($this->CustomDimensions as $index => $value) {
                $index = 'cd' . $index;
                $this->Data[$index] = $value;
            }
        }

        // Add custom metrics (cm).
        if (!empty($this->CustomMetrics)) {
            foreach ($this->CustomMetrics as $index => $value) {
                $index = 'cm' . $index;
                $this->Data[$index] = $value;
            }
        }

        if ($this->Debug) {
            $url = 'https://www.google-analytics.com/debug/collect';
        } else {
            $url = 'https://www.google-analytics.com/collect';
        }

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $user_agent = 'StoreCore/' . STORECORE_VERSION;
        }

        $payload_data = http_build_query($this->Data);
        $payload_data = utf8_encode($payload_data);

        foreach ($this->RequiredParameters as $param) {
            if (!array_key_exists($param, $this->Data)) {
                return $payload_data;
            }
        }

        $ch = curl_init();
        if ($ch == false) {
            return $payload_data;
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_data);

        if (curl_exec($ch)) {
            curl_close($ch);
            return true;
        } else {
            curl_close($ch);
            return $payload_data;
        }
    }

    /**
     * Enable debug mode.
     *
     * @param void
     * @return $this
     */
    public function debug()
    {
        $this->Debug = true;
        return $this;
    }

    /**
     * Set the client ID (cid).
     *
     * @param \StoreCore\Types\ClientID $client_id
     * @return $this
     * @uses \StoreCore\Types\ClientID::__toString()
     */
    public function setClientID(\StoreCore\Types\ClientID $client_id)
    {
        $this->Data['cid'] = strval($client_id);
        return $this;
    }

    /**
     * Set the content group (cg)
     *
     * @param string $content_group
     *   The value of a content group is hierarchichal text delimited by '/'.
     *   Leading and trailing slashes will be removed and any repeated slashes
     *   will be reduced to a single slash.
     *
     * @param int $index
     *   Optional content group index ranging from 1 through 10.  If this
     *   optional parameter is not set, the index is derived from the content
     *   group hierarchy.  For example, 'news/sports' will have an index of 2,
     *   assuming that 'news' has index 1 one level up in the hierarchy.
     */
    public function setContentGroup($content_group, $index = null)
    {
        while (false !== strpos($content_group, '//')) {
            str_ireplace('//', '/', $content_group);
        }
        $content_group = trim($content_group);
        $content_group = trim($content_group, '/');

        if ($index === null) {
            $index = 1 + substr_count($content_group, '/');
        }

        $index = 'cg' . $index;
        $this->Data[$index] = $content_group;
        return $this;
    }

    /**
     * Add and optionally set the currency (cu).
     *
     * @param string $currency_code.
     *   Optional ISO 4217 currency code.  Defaults to 'EUR' for European euro.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setCurrency($currency_code = 'EUR')
    {
        if (!is_string($currency_code)) {
            throw new \InvalidArgumentException();
        }

        $currency_code = trim($currency_code);
        if (strlen($currency_code) !== 3) {
            throw new \InvalidArgumentException();
        }

        $currency_code = strtoupper($currency_code);
        $this->Data['cu'] = $currency_code;
        return $this;
    }


    /**
     * Set a custom dimension text (cd).
     *
     * @param string $custom_dimension_text
     * @return $this
     */
    public function setCustomDimension($custom_dimension_text, $index = null)
    {
        if ($index === null) {
            if (empty($this->CustomDimensions)) {
                $this->CustomDimensions[1] = $custom_dimension_text;
            } else {
                $this->CustomDimensions[] = $custom_dimension_text;
            }
        } else {
            $this->CustomDimensions[$index] = $custom_dimension_text;
        }
        return $this;
    }

    /**
     * Set a custom metric number (cm).
     *
     * @param float|int $custom_metric_number
     * @return $this
     */
    public function setCustomMetric($custom_metric_number, $index = null)
    {
        if ($index === null) {
            if (empty($this->CustomMetrics)) {
                $this->CustomMetrics[1] = $custom_metric_number;
            } else {
                $this->CustomMetrics[] = $custom_metric_number;
            }
        } else {
            $this->CustomMetrics[$index] = $custom_metric_number;
        }
        return $this;
    }

    /**
     * Set the data source (ds).
     *
     * @param string $data_source
     *   By default, hits sent from analytics.js will have data source set to
     *   'web'; hits sent from one of the mobile SDKs will have data source set
     *   to 'app'.  Other data sources are allowed, for example 'crm'.
     *
     * @return $this
     */
    public function setDataSource($data_source)
    {
        $this->Data['ds'] = $data_source;
        return $this;
    }

    /**
     * Set the document host name (dh).
     *
     * @param string $document_hostname
     * @return $this
     */
    public function setDocumentHostname($document_hostname)
    {
        $this->Data['dh'] = $document_hostname;
        return $this;
    }

    /**
     * Set the HTTP document referrer (dr).
     *
     * @param string $document_referrer
     * @return $this
     */
    public function setDocumentReferrer($document_referrer)
    {
        if (filter_var($document_referrer, FILTER_VALIDATE_URL) !== false) {
            $this->Data['dr'] = $document_referrer;
        }
        return $this;
    }

    /**
     * Set the document path (dp).
     *
     * @param string
     *   The path portion of the page URL.  Should begin with '/'.
     *
     * @return $this
     */
    public function setDocumentPath($document_path)
    {
        $document_path = trim($document_path);
        $document_path = '/' . ltrim($document_path, '/');
        $this->Data['dp'] = $document_path;
        return $this;
    }

    /**
     * Set an exception (exd) that may be fatal (exf).
     *
     * @param string $exception
     * @param bool $fatal
     * @return $this
     */
    public function setException($exception, $fatal = false)
    {
        $this->Data['exd'] = $exception;
        if ($fatal === true) {
            $this->Data['exf'] = 1;
        }
        return $this;
    }

    /**
     * Set an experiment (xid) and the experiment variant (xvar).
     *
     * @param mixed $experiment_id
     * @param mixed $experiment_variant
     * @return $this
     */
    public function setExperiment($experiment_id, $experiment_variant)
    {
        $this->Data['xid']  = $experiment_id;
        $this->Data['xvar'] = $experiment_variant;
        return $this;
    }

    /**
     * Change the hit type.
     *
     * @param string $hit_type
     *   A hit type like 'pageview', 'item' or 'transaction'.  This parameter
     *   may be set to one of the HIT_TYPE_ class constants.  The default type
     *   is 'pageview' and HIT_TYPE_PAGEVIEW.
     *
     * @return $this
     */
    public function setHitType($hit_type)
    {
        $hit_type = trim($hit_type);
        $hit_type = strtolower($hit_type);
        $hit_types = array('event', 'exception', 'item', 'pageview', 'screenview', 'social', 'timing', 'transaction');
        if (in_array($hit_type, $hit_types)) {
            $this->Data['t'] = $hit_type;
        }
        return $this;
    }

    /**
     * Specify a non-interaction hit (ni).
     *
     * @param void
     * @return $this
     */
    public function setNonInteractionHit()
    {
        $this->Data['ni'] = 1;
        return $this;
    }

    /**
     * Set the queue time.
     *
     * @param int $milliseconds
     *
     * @return $this
     */
    public function setQueueTime($milliseconds)
    {
        $this->Data['qt'] = $milliseconds;
        return $this;
    }

    /**
     * Set the tracking ID (tid).
     *
     * @param string $tracking_id
     *   Tracking ID or property ID (UA-XXXXX-Y).
     *
     * @return $this
     */
    public function setTrackingID($tracking_id)
    {
        $this->Data['tid'] = $tracking_id;
        return $this;
    }
}
