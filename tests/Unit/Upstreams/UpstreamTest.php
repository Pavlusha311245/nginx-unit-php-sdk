<?php

use UnitPhpSdk\Config\Upstream;
use UnitPhpSdk\Config\Upstream\Server;
use UnitPhpSdk\Exceptions\UnitException;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\expectException;
use function PHPUnit\Framework\expectExceptionMessage;

it('initializes name properly', function () {
    $upstream = new Upstream('upstream1');

    assertSame('upstream1', $upstream->getName());
});


// TODO: fix this test
//it('sets server with valid pass and weight', function () {
//    $upstream = new Upstream('upstream1');
//    $pass = 'http://192.168.0.1:8080';
//    $weight = 2;
//    $upstream->setServer($pass, $weight);
//
//    assertEquals([$pass => ['weight' => $weight]], $upstream->getServers());
//});

it('throws an exception for invalid weight', function () {
    $upstream = new Upstream('upstream1');
    $pass = 'http://192.168.0.1:8080';
    $invalid_weight = -1;

    $upstream->setServer($pass, $invalid_weight);
})->throws(OutOfRangeException::class, 'Weight should be between 0 and 1000000');

it('throws an exception for invalid pass', function () {
    $upstream = new Upstream('upstream1');
    $invalid_pass = 'http://256.256.256.256:8080';

    $upstream->setServer($invalid_pass);
})->throws(UnitException::class, "256.256.256.256 isn't a valid IP address");

it('converts object\'s properties to associative array correctly', function () {
    $upstream = new Upstream('upstream1', [new Server('http://127.0.0.1:8080', 1)]);

    $expectedArray = [
        'servers' => [
            'http://127.0.0.1:8080' => [
                'weight' => 1
            ]
        ]
    ];

    assertEquals($expectedArray, $upstream->toArray());
});

it('converts object\'s properties to json format correctly', function () {
    $upstream = new Upstream('upstream1', [new Server('http://127.0.0.1:8080', 1)]);

    $expectedJson = json_encode([
        'servers' => [
            'http://127.0.0.1:8080' => [
                'weight' => 1
            ]
        ]
    ]);

    assertEquals($expectedJson, $upstream->toJson());
});
