<?php

use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\Automount;

it('checks language_deps manipulation', function () {
    $automount = new Automount(['language_deps' => true]);
    expect($automount->getLanguageDeps())->toBeTrue();
    $automount->setLanguageDeps(false);
    expect($automount->getLanguageDeps())->toBeFalse();
});

it('checks procfs manipulation', function () {
    $automount = new Automount(['procfs' => true]);
    expect($automount->getProcfs())->toBeTrue();
    $automount->setProcfs(false);
    expect($automount->getProcfs())->toBeFalse();
});

it('checks tmpfs manipulation', function () {
    $automount = new Automount(['tmpfs' => true]);
    expect($automount->getTmpfs())->toBeTrue();
    $automount->setTmpfs(false);
    expect($automount->getTmpfs())->toBeFalse();
});

it('transforms object data to array', function () {
    $automount = new Automount([
        'language_deps' => true,
        'procfs' => false,
        'tmpfs' => null,
    ]);

    $expectedArray = [
        'language_deps' => true,
        'procfs' => false,
        'tmpfs' => null,
    ];

    expect($automount->toArray())->toBe($expectedArray);
});

it('creates an object with correct data', function () {
    $automount = new Automount([
        'language_deps' => false,
        'procfs' => true,
        'tmpfs' => false,
    ]);

    expect($automount->toArray())->toBe([
        'language_deps' => false,
        'procfs' => true,
        'tmpfs' => false,
    ]);
});

it('modifies data after object creation', function () {
    $automount = new Automount([]);

    $automount->setLanguageDeps(true);
    $automount->setProcfs(false);
    $automount->setTmpfs(true);

    expect($automount->toArray())->toBe([
        'language_deps' => true,
        'procfs' => false,
        'tmpfs' => true,
    ]);
});

it('handles array with missing keys', function () {
    $automount = new Automount([
        'language_deps' => true,
    ]);

    expect($automount->getLanguageDeps())->toBeTrue()
        ->and($automount->getProcfs())->toBeNull()
        ->and($automount->getTmpfs())->toBeNull();
});