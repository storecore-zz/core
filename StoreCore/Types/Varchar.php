<?php
namespace StoreCore\Types;

class Varchar implements TypeInterface
{
    const VERSION = '0.1.0';
    
    protected $Value;

    public function __construct($initial_value, $strict = true)
    {
        if ($strict && !is_string($initial_value)) {
            throw new \InvalidArgumentException();
        }

        mb_internal_encoding('UTF-8');
        if (mb_strlen($initial_value) > 255) {
            throw new \DomainException();
        }

        $this->Value = (string)$initial_value;
    }

    public function __toString()
    {
        return $this->Value;
    }
}
