<?php

use UnitPhpSdk\Config\Application\Targets\PythonTarget;
use UnitPhpSdk\Exceptions\RequiredKeyException;

it('throws RequiredKeyException when module is not provided', function () {
    $data = ['callable' => 'main'];
    $this->expectException(RequiredKeyException::class);
    $this->expectExceptionMessage('module');

    new PythonTarget($data);
});

it('sets and gets the module correctly', function () {
    $data = ['module' => 'app.module'];
    $pythonTarget = new PythonTarget($data);

    expect($pythonTarget->getModule())->toBe('app.module');
});

it('sets and gets the callable correctly', function () {
    $data = ['module' => 'app.module', 'callable' => 'main'];
    $pythonTarget = new PythonTarget($data);

    expect($pythonTarget->getCallable())->toBe('main');
});

it('uses default callable when not provided', function () {
    $data = ['module' => 'app.module'];
    $pythonTarget = new PythonTarget($data);

    expect($pythonTarget->getCallable())->toBe('application');
});

it('converts the object to array correctly', function () {
    $data = ['module' => 'app.module', 'callable' => 'main'];
    $pythonTarget = new PythonTarget($data);

    expect($pythonTarget->toArray())->toBe($data);
});