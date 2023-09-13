<?php

namespace UnitPhpSdk\Exceptions;

use UnitPhpSdk\Exceptions\UnitException;

class FileNotFoundException extends UnitException
{
    public function __construct()
    {
        parent::__construct('Fail to read file');
    }
}
