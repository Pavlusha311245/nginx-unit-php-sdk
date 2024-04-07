<?php

use UnitPhpSdk\Statistics\Processes;
use UnitPhpSdk\Exceptions\UnitParseException;

use function PHPUnit\Framework\assertEquals;

it('parses data correctly in "Processes"', function () {
    $data = ['running' => 1, 'starting' => 2, 'idle' => 0];
    $processes = new Processes($data);

    assertEquals($data['running'], $processes->getRunning());
    assertEquals($data['starting'], $processes->getStarting());
    assertEquals($data['idle'], $processes->getIdle());
});

it('returns correct data when calling toArray on Processes', function () {
    $data = ['running' => 1, 'starting' => 2, 'idle' => 0];
    $processes = new Processes($data);

    assertEquals($data, $processes->toArray());
});

it('throws exception when trying to instantiate Processes with invalid data', function () {
    $data = ['invalidKey' => 1];

    $this->expectException(UnitParseException::class);

    new Processes($data);
});
