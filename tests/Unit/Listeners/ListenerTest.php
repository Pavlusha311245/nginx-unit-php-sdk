<?php

use UnitPhpSdk\Config\Listener;
use UnitPhpSdk\Config\Listener\ListenerPass;
use UnitPhpSdk\Config\Listener\Tls;
use UnitPhpSdk\Config\Listener\Forwarded;

it('Initializes the Listener class and checks if it is secure', function () {
    $pass = new ListenerPass('test');
    $tls = new Tls([]);
    $forwarded = new Forwarded(['source' => '*']);

    $listener = new Listener('*:8080', $pass, $tls, $forwarded);

    // Test getLink method
    expect($listener->getLink('192.168.0.1'))->toBe('https://192.168.0.1:8080')
        ->and($listener->isSecure())->toBeTrue();

    // Test isSecure method
});

it('Initializes the Listener class without tls and checks if it is not secure', function () {
    $pass = new ListenerPass('test');
    $forwarded = new Forwarded(['source' => '*']);

    $listener = new Listener('*:8080', $pass, null, $forwarded);

    // Test getLink method
    expect($listener->getLink('192.168.0.1'))->toBe('http://192.168.0.1:8080')
        ->and($listener->isSecure())->toBeFalse();

    // Test isSecure method
});
