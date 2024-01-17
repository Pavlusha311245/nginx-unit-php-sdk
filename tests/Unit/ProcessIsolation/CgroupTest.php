<?php

use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\Cgroup;
use UnitPhpSdk\Exceptions\UnitException;
use PHPUnit\Framework\TestCase;

it('returns correct path ', function () {
    $data = ['path' => '/test/path'];

    $cgroup = new Cgroup($data);

    $this->assertEquals('/test/path', $cgroup->getPath());
});

it('performs correct conversion to array', function () {
    $data = ['path' => '/test/path'];

    $cgroup = new Cgroup($data);

    $this->assertEquals(['path' => '/test/path'], $cgroup->toArray());
});

it('throws exception when path is missing', function () {
    $this->expectException(UnitException::class);
    $this->expectExceptionMessage('Cgroup path not found');

    new Cgroup([]);
});
