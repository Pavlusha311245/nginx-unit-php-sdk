<?php

namespace UnitPhpSdk\Exceptions;

class FileNotFoundException extends UnitException
{
    public function __construct()
    {
        parent::__construct('Fail to read file');
    }
}
