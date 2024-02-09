<?php

use UnitPhpSdk\Config\Application\Options\PhpOptions;

it('checks that PhpOptions correctly sets and gets admin values', function () {
    $phpOptions = new PhpOptions();

    $admin = ['admin1' => 'value1', 'admin2' => 'value2'];
    $phpOptions->setAdmin($admin);

    expect($phpOptions->getAdmin())->toBe($admin);
});

it('checks that PhpOptions correctly sets and gets user values', function () {
    $phpOptions = new PhpOptions();

    $user = ['user1' => 'value1', 'user2' => 'value2'];
    $phpOptions->setUser($user);

    expect($phpOptions->getUser())->toBe($user);
});

it('checks that PhpOptions correctly sets and gets file', function () {
    $phpOptions = new PhpOptions();

    $file = '/path/to/php.ini';
    $phpOptions->setFile($file);

    expect($phpOptions->getFile())->toBe($file);
});

it('checks that PhpOptions returns values as an array', function () {
    $phpOptions = new PhpOptions();

    $admin = ['admin1' => 'value1', 'admin2' => 'value2'];
    $phpOptions->setAdmin($admin);

    $user = ['user1' => 'value1', 'user2' => 'value2'];
    $phpOptions->setUser($user);

    $file = '/path/to/php.ini';
    $phpOptions->setFile($file);

    $expectedArray = [
        'admin' => $admin,
        'user' => $user,
        'file' => $file,
    ];

    expect($phpOptions->toArray())->toBe($expectedArray);
});