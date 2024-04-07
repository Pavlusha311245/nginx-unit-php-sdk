<?php

use UnitPhpSdk\Config\Settings\Http;

it('can create Http class', function () {
    $config = new Http();

    // Here you can add assertions to validate the class methods

    expect($config->getBodyReadTimeout())->toBe(30)
        ->and($config->getHeaderReadTimeout())->toBe(30)
        ->and($config->getIdleTimeout())->toBe(180)
        ->and($config->getMaxBodySize())->toBe(8388608)
        ->and($config->getSendTimeout())->toBe(30)
        ->and($config->getStatic())->toBeNull()
        ->and($config->isDiscardUnsafeFields())->toBe(true)
        ->and($config->isLogRoute())->toBe(false)
        ->and($config->isServerVersion())->toBe(true);
});
