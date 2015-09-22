<?php
namespace StoreCore\Types;

class CacheKey
{
    const VERSION = '0.1.0-alpha.1';

    /** @var string $Key */
    private $Key = '';

    /**
     * @param string $str
     */
    public function __construct($str)
    {
        $this->set($str);
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
    
    /**
     * @param void
     * @return string
     */
    public function get()
    {
        return $this->Key;
    }

    /**
     * @param string
     * @return void
     */  
    private function set($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $this->Key = md5($str);
    }
}
