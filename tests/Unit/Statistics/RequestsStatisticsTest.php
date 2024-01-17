<?php

use UnitPhpSdk\Statistics\RequestsStatistics;
use UnitPhpSdk\Exceptions\UnitParseException;

// Existing tests
it('tests getTotalRequests and toArray methods', function () {
    $statistics = new RequestsStatistics(['total' => 10]);
    $this->assertEquals(10, $statistics->getTotalRequests());
    $this->assertEquals(['total' => 10], $statistics->toArray());
});

it('tests constructor exceptions', function () {
    $this->expectException(UnitParseException::class);
    $this->expectExceptionMessage("Key 'total' not present");
    new RequestsStatistics([]);
})->group('exception');

// Additional tests
it('tests getTotalRequests and toArray methods with zero total', function () {
    $statistics = new RequestsStatistics(['total' => 0]);
    $this->assertEquals(0, $statistics->getTotalRequests());
    $this->assertEquals(['total' => 0], $statistics->toArray());
});

it('tests constructor exceptions with non-integer total', function () {
    $this->expectException(UnitParseException::class);
    $this->expectExceptionMessage("Key 'total' must be integer");
    new RequestsStatistics(['total' => 'non-integer']);
})->group('exception');
