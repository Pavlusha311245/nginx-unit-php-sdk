<?php

namespace UnitPhpSdk\Exceptions;

/**
 * Class FileNotFoundException
 *
 * This class represents an exception that is thrown when a file cannot be found or opened for reading.
 * It extends the UnitException class.
 */
class FileNotFoundException extends UnitException
{
    /**
     * The constructor method for the class.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Fail to open file');
    }
}
