<?php

use UnitPhpSdk\Config\Upstream;
use UnitPhpSdk\Exceptions\UnitException;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

it('initializes name properly', function () {
    $upstream = new Upstream('upstream1', ['servers' => [['127.0.0.1', 1]]]);

    assertSame('upstream1', $upstream->getName());
});

it('sets servers during initialization', function () {
    $servers = [
        '127.0.0.1' => ['weight' => 1],
        '192.168.0.1' => ['weight' => 2]
    ];
    $upstream = new Upstream('upstream1', ['servers' => $servers]);

    assertSame($servers, $upstream->getServers());
});

it('sets server with valid IP and weight', function () {
    $upstream = new Upstream('upstream1');
    $ip = '192.168.0.1';
    $weight = 2;
    $upstream->setServer($ip, $weight);

    assertEquals([$ip => ['weight' => $weight]], $upstream->getServers());
});

it('throws an exception for invalid weight', function () {
    $upstream = new Upstream('upstream1');
    $upstream->setServer('192.168.0.1', -1);
})->throws(OutOfRangeException::class, 'Weight should be between 0 and 1000000');

it('throws an exception for invalid IP', function () {
    $upstream = new Upstream('upstream1');
    $upstream->setServer('256.256.256.256');
})->throws(UnitException::class, "256.256.256.256 isn't a valid IP address");
