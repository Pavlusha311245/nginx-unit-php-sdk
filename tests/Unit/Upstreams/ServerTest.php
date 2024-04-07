<?php

use UnitPhpSdk\Config\Upstream\Server;
use UnitPhpSdk\Exceptions\UnitException;

use function PHPUnit\Framework\assertEquals;

it('sets and gets pass successfully', function () {
    $pass = 'http://127.0.0.1:8000';
    $server = new Server($pass, 1);

    assertEquals($pass, $server->getPass());
});

it('throws an exception when invalid pass is provided', function () {
    $pass = 'http://invalid';
    $server = new Server($pass, 1);

    $server->setPass($pass);
})->throws(UnitException::class, ' isn\'t a valid IP address') ;

// TODO: fix this test
//it('throws exception when invalid port is used while setting pass', function () {
//    $invalidPort = 'http://127.0.0.1:99999';
//    $server = new Server();
//
//    $server->setPass($invalidPort);
//})->throws(UnitException::class, ' isn\'t a valid port number (allowed range is 1 to 65535)');

it('sets and gets weight successfully', function () {
    $weight = 2;
    $server = new Server('http://127.0.0.1:8000', $weight);

    assertEquals($weight, $server->getWeight());
});

it('throws an exception when invalid weight is provided', function () {
    $weight = 1000001;
    $server = new Server('http://127.0.0.1:8000', $weight);
})->throws(OutOfRangeException::class, 'Weight should be between 0 and 1000000');
