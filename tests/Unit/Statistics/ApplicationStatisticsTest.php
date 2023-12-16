<?php

namespace tests\UnitPhpSdk\Statistics;

use UnitPhpSdk\Statistics\ApplicationStatistics;
use Pest\TestSuite;

it('ApplicationStatistics getRequests method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['requests'], $applicationStatistics->getRequests());
});

it('ApplicationStatistics getActiveRequests method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['requests']['active'], $applicationStatistics->getActiveRequests());
});

it('ApplicationStatistics getProcesses method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['processes'], $applicationStatistics->getProcesses());
});

it('ApplicationStatistics getStartingProcesses method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['processes']['starting'], $applicationStatistics->getStartingProcesses());
});

it('ApplicationStatistics getRunningProcesses method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['processes']['running'], $applicationStatistics->getRunningProcesses());
});

it('ApplicationStatistics getIdleProcesses method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data['processes']['idle'], $applicationStatistics->getIdleProcesses());
});

it('ApplicationStatistics toArray method test', function () {
    $data = [
        'requests' => ['active' => 5],
        'processes' => ['starting' => 2, 'running' => 3, 'idle' => 1]
    ];

    $applicationStatistics = new ApplicationStatistics($data);

    $this->assertEquals($data, $applicationStatistics->toArray());
});
