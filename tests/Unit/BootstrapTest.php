<?php

use UnitPhpSdk\Unit;

const SOCKET = '/usr/local/var/run/unit/control.sock';
const ADDRESS = 'http://localhost';

test('Can create unit object', function () {
    expect(new Unit(
        address: ADDRESS,
        socket: SOCKET
    ))->toBeObject();
});

$unit = new Unit(
    address: ADDRESS,
    socket: SOCKET
);

test('Can receive socket', function () use ($unit) {
    expect($unit->getSocket())->toBeString();
});

test('Can receive address', function () use ($unit) {
    expect($unit->getAddress())->toBeString();
});

test('Can receive config', function () use ($unit) {
    expect($unit->getConfig())->toBeObject('received object');
});

test('Can receive statistics', function () use ($unit) {
    expect($unit->getStatistics())->toBeObject('received object');
});

test('Can receive certificates', function () use ($unit) {
    expect($unit->getCertificates())->toBeArray('received array');
});
