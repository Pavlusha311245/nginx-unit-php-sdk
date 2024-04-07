<?php

namespace UnitPhpSdk\Exceptions;

/**
 * Class RequiredKeyException
 *
 * Custom exception class for indicating missing required keys.
 */
class RequiredKeyException extends UnitException
{
    /**
     * Constructor.
     *
     * @param string ...$keys The required keys.
     * @return void
     */
    public function __construct(string ...$keys)
    {
        $keysAsString = implode('\', \'', $keys);

        parent::__construct("Missing keys '{$keysAsString}' is required");
    }
}
