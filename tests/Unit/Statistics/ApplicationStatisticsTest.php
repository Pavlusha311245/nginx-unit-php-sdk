<?php

use UnitPhpSdk\Statistics\ApplicationStatistics;
use UnitPhpSdk\Exceptions\UnitParseException;

it('creates ApplicationStatistics instance correctly', function () {
    $data = [
        'processes' => [
            'running' => 10,
            'starting' => 5,
            'idle' => 2
        ],
        'requests' => [
            'active' => 100
        ]
    ];

    $appStats = new ApplicationStatistics($data);

    $this->assertEquals(100, $appStats->getActiveRequests());
    $this->assertEquals($data['processes'], $appStats->getProcesses());
    $this->assertEquals(10, $appStats->getRunningProcesses());
    $this->assertEquals(5, $appStats->getStartingProcesses());
    $this->assertEquals(2, $appStats->getIdleProcesses());
    $this->assertEquals($data, $appStats->toArray());
});

it(/**
 * @throws UnitParseException
 */ 'throws UnitParseException when created without all necessary data', function () {
    $data = [
        'processes' => [
            'running' => 10,
            'idle' => 2,
        ],
        'requests' => [
            'active' => 100
        ]
    ];


    $this->expectException(UnitParseException::class);
    $this->expectExceptionMessage('One or more keys are don\'t exists');

    $appStats = new ApplicationStatistics($data);
});
