<?php

// Test for ConnectionsStatistics methods
use UnitPhpSdk\Contracts\ApplicationStatisticsInterface;
use UnitPhpSdk\Contracts\ConnectionsStatisticsInterface;
use UnitPhpSdk\Contracts\RequestsStatisticsInterface;
use UnitPhpSdk\Statistics\ApplicationStatistics;
use UnitPhpSdk\Statistics\Statistics;

$statData = [
    'connections' => [
        'idle' => 5,
        'active' => 2,
        'accepted' => 7,
        'closed' => 2
    ],
    'requests' => [
        'total' => 50
    ],
    'applications' => [
        'application1' => [
            'requests' => [
                'active' => 0
            ],
            'processes' => [
                'running' => 14,
                'starting' => 0,
                'idle' => 4
            ],
        ],
    ],
];

$connectionsData = $statData['connections'];
$appData = $statData['applications']['application1'];

it('tests connections methods', function () use ($statData, $connectionsData) {
    $statistics = new Statistics($statData);
    $this->assertInstanceOf(ConnectionsStatisticsInterface::class, $statistics->getConnections());
    $this->assertEquals($statistics->getConnections()->getActiveConnections(), $connectionsData['active']);
});
// Test for RequestsStatistics methods
it('tests requests methods', function () use ($statData) {
    $statistics = new Statistics($statData);
    $this->assertInstanceOf(RequestsStatisticsInterface::class, $statistics->getRequests());
});
// Test for ApplicationStatistics methods
it('tests applications methods', function () use ($statData, $appData) {
    $statistics = new Statistics($statData);
    $expectedApplicationStatistics = new ApplicationStatistics((array)$appData);
    $application = 'application1';
    $this->assertIsArray($statistics->getApplications());
    $this->assertInstanceOf(ApplicationStatisticsInterface::class, $statistics->getApplicationStatistics($application));
    $this->assertEquals($expectedApplicationStatistics->getActiveRequests(), $statistics->getApplicationStatistics($application)->getActiveRequests());
    $this->assertEquals($expectedApplicationStatistics->getProcesses(), $statistics->getApplicationStatistics($application)->getProcesses());
    $this->assertEquals($expectedApplicationStatistics->getRunningProcesses(), $statistics->getApplicationStatistics($application)->getRunningProcesses());
    $this->assertEquals($expectedApplicationStatistics->getStartingProcesses(), $statistics->getApplicationStatistics($application)->getStartingProcesses());
    $this->assertEquals($expectedApplicationStatistics->getIdleProcesses(), $statistics->getApplicationStatistics($application)->getIdleProcesses());
    $this->assertIsArray($statistics->getApplicationStatistics($application)->getRequests());
});
// Test for invalid application
it('throws exception for invalid application', function () use ($statData) {
    $statistics = new Statistics($statData);
    $this->expectException(InvalidArgumentException::class);
    $statistics->getApplicationStatistics('nonexistentApplication');
});
// Test toArray method
it('tests toArray method', function () use ($statData) {
    $statistics = new Statistics($statData);
    $this->assertIsArray($statistics->toArray());
    $this->assertEquals($statData, $statistics->toArray());
});
