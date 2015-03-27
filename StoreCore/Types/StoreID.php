<?php
namespace StoreCore\Types;

final class StoreID extends TinyintUnsigned implements TypeInterface
{
    public function __construct($initial_value = 1, $strict = true) {
        parent::__construct($initial_value, $strict);
        if ($initial_value < 1) {
            throw new \DomainException();
        }
    }
}
