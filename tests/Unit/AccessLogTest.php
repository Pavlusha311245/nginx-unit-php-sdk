<?php

use UnitPhpSdk\Config\AccessLog;
use PHPUnit\Framework\Assert;

it('can be created from data array', function () {
    $data = [
        'path' => '/var/log/access.log',
        'format' => '%h %l %u %t \"%r\" %>s %b',
    ];

    $accessLog = new AccessLog($data);

    Assert::assertSame($data['path'], $accessLog->getPath());
    Assert::assertSame($data['format'], $accessLog->getFormat());
});

it('can set and get path', function () {
    $accessLog = new AccessLog([]);

    $path = '/var/log/access.log';
    $accessLog->setPath($path);

    Assert::assertSame($path, $accessLog->getPath());
});

it('can set and get format', function () {
    $accessLog = new AccessLog([]);

    $format = '%h %l %u %t \"%r\" %>s %b';
    $accessLog->setFormat($format);

    Assert::assertSame($format, $accessLog->getFormat());
});
