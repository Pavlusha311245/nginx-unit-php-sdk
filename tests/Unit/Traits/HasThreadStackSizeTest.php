<?php

use Pest\TestSuite;
use UnitPhpSdk\Traits\HasThreadStackSize;

use function PHPUnit\Framework\assertNull;

it('tests HasThreadStackSize trait', function () {
    $class = new class () {
        use HasThreadStackSize;
    };

    // The default value should be null
    expect($class->getThreadStackSize())->toBeNull();

    $class->setThreadStackSize(1024);

    // Check if the set value matches expected
    expect($class->getThreadStackSize())->toEqual(1024);
});
