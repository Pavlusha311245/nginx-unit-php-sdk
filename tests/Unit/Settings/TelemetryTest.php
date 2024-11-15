<?php


use UnitPhpSdk\Config\Settings\Telemetry;
use UnitPhpSdk\Enums\TelemetryProtocolEnum;

it('can create a Telemetry instance with required properties', function () {
    $endpoint = 'http://localhost:4318';
    $protocol = TelemetryProtocolEnum::HTTP;

    $telemetry = new Telemetry($endpoint, $protocol);

    expect($telemetry->getEndpoint())->toBe($endpoint)
        ->and($telemetry->getProtocol())->toBe($protocol);
});

it('can set and get batch size', function () {
    $telemetry = new Telemetry('http://localhost:4318', TelemetryProtocolEnum::GRPC);

    $telemetry->setBatchSize(100);
    expect($telemetry->getBatchSize())->toBe(100);

    $telemetry->setBatchSize(null);
    expect($telemetry->getBatchSize())->toBeNull();
});

it('can set and get sampling ratio', function () {
    $telemetry = new Telemetry('http://localhost:4318', TelemetryProtocolEnum::GRPC);

    $telemetry->setSamplingRatio(0.5);
    expect($telemetry->getSamplingRatio())->toBe(0.5);

    $telemetry->setSamplingRatio(null);
    expect($telemetry->getSamplingRatio())->toBeNull();
});

it('can update endpoint and protocol', function () {
    $telemetry = new Telemetry('http://localhost:4318', TelemetryProtocolEnum::GRPC);

    $newEndpoint = 'http://example.com:4318';
    $newProtocol = TelemetryProtocolEnum::GRPC;

    $telemetry->setEndpoint($newEndpoint);
    $telemetry->setProtocol($newProtocol);

    expect($telemetry->getEndpoint())->toBe($newEndpoint)
        ->and($telemetry->getProtocol())->toBe($newProtocol);
});