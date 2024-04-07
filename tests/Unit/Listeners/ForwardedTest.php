<?php

use UnitPhpSdk\Config\Listener\Forwarded;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;

// Testing the constructor
it(/**
 * @throws UnitException
 */ 'throws exception when the source key is not present', function () {
    $data = [
        'client_ip' => '127.0.0.1',
        'protocol' => 'http',
        'recursive' => false
    ];
    $this->expectException(RequiredKeyException::class);
    new Forwarded($data);
})->group('Forwarded');

it('constructs successfully when the source key is present', function () {
    $data = [
        'source' => '127.0.0.1',
        'client_ip' => '127.0.0.1',
        'protocol' => 'http',
        'recursive' => false
    ];
    $forwarded = new Forwarded($data);
    expect($forwarded)->toBeInstanceOf(Forwarded::class);
})->group('Forwarded');

// Testing the getters and setters
it('sets and retrieves source correctly', function () {
    $forwarded = new Forwarded(['source' => '127.0.0.1']);
    $forwarded->setSource(['192.168.1.1', '192.168.1.2']);
    expect($forwarded->getSource())->toBeArray()->toContain('192.168.1.1', '192.168.1.2');
})->group('Forwarded');

it('sets and retrieves protocol correctly', function () {
    $forwarded = new Forwarded(['source' => '127.0.0.1']);
    $forwarded->setProtocol('https');
    expect($forwarded->getProtocol())->toBe('https');
})->group('Forwarded');

it('sets and retrieves client IP correctly', function () {
    $forwarded = new Forwarded(['source' => '127.0.0.1']);
    $forwarded->setClientIp('192.168.1.1');
    expect($forwarded->getClientIp())->toBe('192.168.1.1');
})->group('Forwarded');

it('sets and retrieves recursive correctly', function () {
    $forwarded = new Forwarded(['source' => '127.0.0.1']);
    $forwarded->setRecursive(true);
    expect($forwarded->isRecursive())->toBe(true);
})->group('Forwarded');

// Testing behavior
it('converts to array correctly', function () {
    $data = [
        'source' => '127.0.0.1',
        'client_ip' => '127.0.0.1',
        'protocol' => 'http',
        'recursive' => false
    ];
    $forwarded = new Forwarded($data);
    expect($forwarded->toArray())->toBeArray()->toHaveKeys(['source', 'client_id', 'recursive', 'protocol']);
})->group('Forwarded');

it('converts to JSON correctly', function () {
    $data = [
        'source' => '127.0.0.1',
        'client_ip' => '127.0.0.1',
        'protocol' => 'http',
        'recursive' => false
    ];
    $forwarded = new Forwarded($data);
    expect(json_decode($forwarded->toJson(), true))->toBeArray()->toHaveKeys(['source', 'client_id', 'recursive', 'protocol']);
})->group('Forwarded');
