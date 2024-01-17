<?php

use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\Namespaces;

it('tests the Namespaces class', function () {
    $data = ['cgroup' => true, 'credential' => true, 'mount' => false, 'pid' => true, 'network' => true, 'uname' => true];
    $namespaces = new Namespaces($data);

    // Check if the data was set correctly
    expect($namespaces->isCgroup())->toBeTrue()
        ->and($namespaces->isCredential())->toBeTrue()
        ->and($namespaces->isMount())->toBeFalse()
        ->and($namespaces->isPid())->toBeTrue()
        ->and($namespaces->isNetwork())->toBeTrue()
        ->and($namespaces->isUname())->toBeTrue();

    // Check if the toArray() method works correctly
    expect($namespaces->toArray())->toBe($data);
});
