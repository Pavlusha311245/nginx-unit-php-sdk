<?php

namespace UnitPhpSdk\Exceptions;

/**
 * Custom exception
 */
class UnitParseException extends UnitException
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct('Fail to parse: ' . $message);
    }
}
