<?php
namespace StoreCore\Types;

class StoreID extends TinyintUnsigned implements TypeInterface
{
    const VERSION = '0.1.0';
    
    public function __construct($initial_value = 1, $strict = true) {
        parent::__construct($initial_value, $strict);
        if ($initial_value < 1) {
            throw new \DomainException();
        }
    }
}
