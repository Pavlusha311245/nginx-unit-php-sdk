<?php

namespace Tests\Unit;

use Pavlusha311245\UnitPhpSdk\Unit;

$unit = new Unit(
    socket: '/usr/local/var/run/unit/control.sock',
    address: 'http://localhost'
);

$statistics = $unit->getStatistics();

test('Can receive applications statistics', function () use ($statistics) {
    expect($statistics->getApplications())->toBeArray();
});

test('Can receive connections statistics', function () use ($statistics) {
    expect($statistics->getConnections())->toBeObject();
});

test('Can receive connections statistics data', function () use ($statistics) {
    expect($statistics->getConnections()->getData())->toBeArray();
});

test('Can receive accepted connections statistics', function () use ($statistics) {
    expect($statistics->getConnections()->getAcceptedConnections())->toBeInt();
});

test('Can receive active connections statistics', function () use ($statistics) {
    expect($statistics->getConnections()->getActiveConnections())->toBeInt();
});

test('Can receive closed connections statistics', function () use ($statistics) {
    expect($statistics->getConnections()->getClosedConnections())->toBeInt();
});

test('Can receive idle connections statistics', function () use ($statistics) {
    expect($statistics->getConnections()->getIdleConnections())->toBeInt();
});

test('Can receive requests statistics', function () use ($statistics) {
    expect($statistics->getRequests())->toBeObject();
});

test('Can receive total requests statistics', function () use ($statistics) {
    expect($statistics->getRequests()->getTotalRequests())->toBeInt();
});
