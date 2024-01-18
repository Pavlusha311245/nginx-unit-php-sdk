<?php

use UnitPhpSdk\Exceptions\UnitException;

it('can be constructed and correctly passes messages', function() {
    $message = 'Test message';
    $unitException = new UnitException($message);

    expect($unitException->getMessage())->toBe($message);
});