<?php

namespace UnitPhpSdk\Exceptions;

class RequiredKeyException extends UnitException
{
    public function __construct(string ...$keys)
    {
        $keysAsString = implode('\', \'', $keys);

        parent::__construct("Missing keys '{$keysAsString}' is required");
    }
}
