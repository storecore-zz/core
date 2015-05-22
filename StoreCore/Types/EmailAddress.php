<?php
namespace StoreCore\Types;

class EmailAddress extends Varchar implements TypeInterface
{
    const VERSION = '0.1.0';

    public function __construct($initial_value, $strict = true)
    {
        parent::__construct($initial_value, $strict);

        if (mb_strlen($this->Value) < 3) {
            throw new \DomainException();
        }

        // Check for the last '@' at-sign position
        $pos = mb_strrpos($this->Value, '@');
        if ($pos === false) {
            throw new \InvalidArgumentException();
        }

        if (!filter_var($this->Value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException();
        }

        $local_address  = mb_substr($this->Value, 0, $pos);
        $server_address = mb_substr($this->Value, $pos + 1);

        $server_address = mb_strtolower($server_address);

        $this->Value = $local_address . '@' . $server_address;
    }
}
