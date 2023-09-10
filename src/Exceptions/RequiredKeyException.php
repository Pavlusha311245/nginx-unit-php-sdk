<?php

namespace UnitPhpSdk\Exceptions;

class RequiredKeyException extends UnitException
{
    public function __construct(string $key = "")
    {
        parent::__construct("Missing key '{$key}' is required");
    }
}
