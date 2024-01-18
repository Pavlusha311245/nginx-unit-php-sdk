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

it('initializes class properties correctly', function () {
    $upstream = new Upstream('upstream1', ['servers' => [['127.0.0.1', 1]]]);

    // Используем ReflectionClass для доступа к private свойствам
    $reflectionClass = new \ReflectionClass($upstream);
    $nameProperty = $reflectionClass->getProperty('name');
    $nameProperty->setAccessible(true);
    $serversProperty = $reflectionClass->getProperty('servers');
    $serversProperty->setAccessible(true);

    assertSame('upstream1', $nameProperty->getValue($upstream));
    assertEquals([['127.0.0.1', 1]], $serversProperty->getValue($upstream));
});

it('converts object\'s properties to associative array correctly', function () {
    $upstream = new Upstream('upstream1', ['servers' => [['127.0.0.1', 1]]]);

    $expectedArray = ['servers' => [['127.0.0.1', 1]]];

    assertEquals($expectedArray, $upstream->toArray());
});

it('converts object\'s properties to json format correctly', function () {
    $upstream = new Upstream('upstream1', ['servers' => [['127.0.0.1', 1]]]);

    $expectedJson = json_encode(['servers' => [['127.0.0.1', 1]]]);

    assertEquals($expectedJson, $upstream->toJson());
});