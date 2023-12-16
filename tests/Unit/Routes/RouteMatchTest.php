<?php

use UnitPhpSdk\Config\Routes\RouteMatch;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Enums\HttpSchemeEnum;

it('tests RouteMatch manipulation', function () {
    $data = [
        'host' => 'test.com',
        'method' => HttpMethodsEnum::POST,
        'destination' => '127.0.0.1',
        'scheme' => HttpSchemeEnum::HTTP,
        'uri' => '/test-uri',
        'arguments' => ['arg' => 'value'],
        'query' => ['query' => 'value'],
        'cookies' => ['cookie' => 'value'],
        'headers' => ['header' => 'value'],
        'source' => 'source'
    ];

    $routeMatch = new RouteMatch($data);

    expect($routeMatch->getHost())->toBe('test.com')
        ->and($routeMatch->getMethod())->toBe(HttpMethodsEnum::POST)
        ->and($routeMatch->getDestination())->toBe('127.0.0.1')
        ->and($routeMatch->getScheme())->toBe(HttpSchemeEnum::HTTP)
        ->and($routeMatch->getUri())->toBe('/test-uri')
        ->and($routeMatch->getArguments())->toBe(['arg' => 'value'])
        ->and($routeMatch->getQuery())->toBe(['query' => 'value'])
        ->and($routeMatch->getCookies())->toBe(['cookie' => 'value'])
        ->and($routeMatch->getHeaders())->toBe(['header' => 'value'])
        ->and($routeMatch->getSource())->toBe('source');

    $routeMatchArray = $routeMatch->toArray();

    expect($routeMatchArray)->toBe($data);
});
