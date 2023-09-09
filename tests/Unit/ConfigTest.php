<?php

namespace Tests\Unit;

use UnitPhpSdk\Unit;

$unit = new Unit(
    socket: '/usr/local/var/run/unit/control.sock',
    address: 'http://localhost'
);

$config = $unit->getConfig();

test('Can receive listeners', function () use ($config) {
    expect($config->getListeners())->toBeArray();
});

test('Can receive applications', function () use ($config) {
    expect($config->getApplications())->toBeArray();
});

test('Can receive routes', function () use ($config) {
    expect($config->getRoutes())->toBeArray();
});

test('Can receive upstreams', function () use ($config) {
    expect($config->getUpstreams())->toBeArray();
});
