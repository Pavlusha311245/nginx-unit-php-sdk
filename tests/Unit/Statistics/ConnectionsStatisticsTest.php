<?php

use UnitPhpSdk\Statistics\ConnectionsStatistics;

it('checks ConnectionsStatistics methods', function () {
    $data = [
        'idle' => 5,
        'active' => 10,
        'accepted' => 15,
        'closed' => 20,
    ];

    $connectionsStatistics = new ConnectionsStatistics($data);

    expect($connectionsStatistics->getIdleConnections())->toBe($data['idle'])
        ->and($connectionsStatistics->getActiveConnections())->toBe($data['active'])
        ->and($connectionsStatistics->getAcceptedConnections())->toBe($data['accepted'])
        ->and($connectionsStatistics->getClosedConnections())->toBe($data['closed'])
        ->and($connectionsStatistics->toArray())->toBe($data);
});
