<?php
namespace StoreCore\Types;

class SmallintUnsigned implements TypeInterface
{
    const VERSION = '0.1.0';

    protected $Value;

    public function __construct($initial_value, $strict = true)
    {
        if ($strict && !is_int($initial_value)) {
            throw new \InvalidArgumentException();
        } elseif (!is_numeric($initial_value)) {
            throw new \InvalidArgumentException();
        }

        if ($initial_value < 0) {
            throw new \DomainException();
        } elseif ($initial_value > 65535) {
            throw new \DomainException();
        }

        $this->Value = (int)$initial_value;
    }

    public function __toString()
    {
        return (string)$this->Value;
    }
}
