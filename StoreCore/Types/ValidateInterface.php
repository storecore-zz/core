<?php
namespace StoreCore\Types;

interface ValidateInterface
{
    /**
     * Validate a variable.
     *
     * By default, all StoreCore data types are internally validated using
     * Standard PHP Library (SPL) exceptions.  The additional static method
     * validate() provided by this interface may be used as a shortcut for
     * validating variables, constants, and input values.  This method acts as
     * a helper function that eliminates the need to instantiate a new object
     * and handle exceptions.
     *
     * @param mixed $variable
     *   The variable, constant, or value to validate.
     *
     * @return bool
     *   Returns true if a variable matches a given StoreCore type or false if
     *   it does not.
     *
     * @throws void
     *   The validate() method MUST NOT throw any exceptions, but merely return
     *   a boolean true or false.
     */
    public static function validate($variable);
}
