<?php

use UnitPhpSdk\Statistics\{Statistics, ApplicationStatistics, ConnectionsStatistics, RequestsStatistics};
use UnitPhpSdk\Contracts\ApplicationStatisticsInterface;
use UnitPhpSdk\Contracts\ConnectionsStatisticsInterface;
use UnitPhpSdk\Contracts\RequestsStatisticsInterface;

it('test statistics', function () {
    $appData = [
        'requests' => [], // assume that you have data here
        'activeRequests' => 0,
        'processes' => [], // assume that you have data here
        'startingProcesses' => 1,
        'runningProcesses' => 1,
        'idleProcesses' => 0,
    ];
    $connectionsData = [
        'idle' => 5,
        'active' => 2,
        'accepted' => 7,
        'closed' => 2,
    ];
    $requestStatsData = [
        'total' => 50,
    ];

    $data = [
        'connections' => $connectionsData,
        'requests' => $requestStatsData,
        'applications' => [
            'application1' => $appData,
        ],
    ];

    $statistics = new Statistics($data);

    // Below are added some partial checks for sample. Add more according to your requirements.

    // Test getConnections method
    $this->assertInstanceOf(ConnectionsStatisticsInterface::class, $statistics->getConnections());
    $this->assertEquals($statistics->getConnections()->getActiveConnections(), $connectionsData['active']);

    // Test getRequests method
    $this->assertInstanceOf(RequestsStatisticsInterface::class, $statistics->getRequests());

    // Test getApplications method
    $this->assertIsArray($statistics->getApplications());

    // Test getApplicationStatistics method
    $application = 'application1';
    $this->assertInstanceOf(ApplicationStatisticsInterface::class, $statistics->getApplicationStatistics($application));
});
