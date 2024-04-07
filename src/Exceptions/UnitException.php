<?php

namespace UnitPhpSdk\Exceptions;

use Exception;

/**
 * The UnitException class is an exception class that extends the base Exception class.
 * It is used to represent exceptions that occur specifically within units.
 *
 * @package Your\Namespace
 */
class UnitException extends Exception
{
    /**
     * Constructor method.
     *
     * @param string $message The message to be set for the object.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
