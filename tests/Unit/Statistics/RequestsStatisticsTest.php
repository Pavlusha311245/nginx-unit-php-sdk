<?php

use UnitPhpSdk\Statistics\RequestsStatistics;
use UnitPhpSdk\Exceptions\UnitParseException;

it('checks total requests and array conversion', function() {
    $data = ['total' => 5, 'foo' => 'bar'];
    $stats = new RequestsStatistics($data);

    // Check if getTotalRequests() returns the correct count
    expect($stats->getTotalRequests())->toBe(5);

    // Check if toArray() returns the original array
    expect($stats->toArray())->toBe($data);
});

it('throws UnitParseException if total is not set', function () {
    $data = ['foo' => 'bar'];

    // Expect a UnitParseException when 'total' key is not set
    new RequestsStatistics($data);

})->throws(UnitParseException::class, "Key 'total' not present");

it('throws UnitParseException if data array is empty', function () {

    // Expect a UnitParseException when the array provided is empty
    new RequestsStatistics([]);

})->throws(UnitParseException::class, "Key 'total' not present");
