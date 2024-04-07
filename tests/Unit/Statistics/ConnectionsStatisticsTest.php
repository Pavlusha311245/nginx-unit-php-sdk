<?php

use UnitPhpSdk\Statistics\ConnectionsStatistics;

it('checks ConnectionsStatistics methods', function () {
    $data = [
        'accepted' => 15,
        'active' => 10,
        'idle' => 5,
        'closed' => 20,
    ];

    $connectionsStatistics = new ConnectionsStatistics($data);

    expect($connectionsStatistics->getAcceptedConnections())->toBe($data['accepted'])
        ->and($connectionsStatistics->getActiveConnections())->toBe($data['active'])
        ->and($connectionsStatistics->getIdleConnections())->toBe($data['idle'])
        ->and($connectionsStatistics->getClosedConnections())->toBe($data['closed'])
        ->and($connectionsStatistics->toArray())->toBe($data);
});
