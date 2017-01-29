<?php
namespace StoreCore\Types;

interface TypeInterface
{
    /**
     * Create a new value of some type.
     *
     * @param mixed $initial_value
     *   Optional default value, to be determined by implementing and
     *   extending classes.
     *
     * @param bool $strict
     *   Enforce strict typing (true) or loose typing (false).
     *
     * @throws Exception
     *   Classes MUST throw exceptions if the initial value does not match
     *   the type definition.
     */
    public function __construct($initial_value, $strict);
}
