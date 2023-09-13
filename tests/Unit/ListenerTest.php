<?php

namespace Tests\Unit;

use UnitPhpSdk\Config\Listener;
use UnitPhpSdk\Exceptions\UnitException;

test('Listener can be created', function () {
    expect(new Listener('*:80', 'routes'))->toBeObject();
});

test('ListenerPass can be created', function () {
    expect(new Listener\ListenerPass('*:8888'))->toBeObject();
});

test('Forwarded object can be created', function () {
    $forwardedObject = new Listener\Forwarded([
        'source' => '127.0.0.1'
    ]);
    expect($forwardedObject)->toBeObject();
});
