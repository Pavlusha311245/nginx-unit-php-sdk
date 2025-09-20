<?php

namespace UnitPhpSdk\Exceptions;

use Exception;
use Throwable;

/**
 * The UnitException class is an exception class that extends the base Exception class.
 * It is used to represent exceptions that occur specifically within units.
 */
class UnitException extends Exception
{
    /**
     * Constructor method.
     *
     * @param string $message The exception message
     * @param int $code The exception code
     * @param Throwable|null $previous Previous throwable used for exception chaining
     */
    public function __construct(
        string     $message = "",
        int        $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
