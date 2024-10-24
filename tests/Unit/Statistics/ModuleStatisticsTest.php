<?php

namespace Tests\Unit\Statistics;

use InvalidArgumentException;
use UnitPhpSdk\Statistics\ModuleStatistics;

it('creates ModuleStatistics instance correctly', function () {
    $data = [
        'version' => '1.0.0',
        'lib' => '/path/to/libfile.so'
    ];

    $moduleStats = new ModuleStatistics($data);

    expect($moduleStats->getVersion())->toBe('1.0.0')
        ->and($moduleStats->getLibPath())->toBe('/path/to/libfile.so')
        ->and($moduleStats->toArray())->toBe([
            'version' => '1.0.0',
            'lib' => '/path/to/libfile.so'
        ]);
});

it(
/**
 * @throws InvalidArgumentException
 */
    'throws InvalidArgumentException when version is missing',
    function () {
        $data = [
            'lib' => '/path/to/libfile.so'
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Version is required');

        new ModuleStatistics($data);
    }
);

it(
/**
 * @throws InvalidArgumentException
 */
    'throws InvalidArgumentException when lib is missing',
    function () {
        $data = [
            'version' => '1.0.0',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Lib is required');

        new ModuleStatistics($data);
    }
);
