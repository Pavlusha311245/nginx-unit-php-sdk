<?php

use UnitPhpSdk\Config\Application\Targets\PhpTarget;

it('sets and gets the script correctly', function () {
    $data = ['root' => '/var/www', 'script' => 'main.php'];
    $phpTarget = new PhpTarget($data);

    expect($phpTarget->getScript())->toBe('main.php');
});

it('sets and gets the index correctly', function () {
    $data = ['root' => '/var/www', 'index' => 'home.php'];
    $phpTarget = new PhpTarget($data);

    expect($phpTarget->getIndex())->toBe('home.php');
});

it('sets and gets the root correctly', function () {
    $data = ['root' => '/var/www'];
    $phpTarget = new PhpTarget($data);

    expect($phpTarget->getRoot())->toBe('/var/www');
});

it('converts the object to array correctly', function () {
    $data = ['root' => '/var/www', 'script' => 'main.php', 'index' => 'home.php'];
    $phpTarget = new PhpTarget($data);

    expect($phpTarget->toArray())->toBe($data);
});