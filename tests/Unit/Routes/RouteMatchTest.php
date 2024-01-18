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

it('should handle different http methods and schemes', function () {
    foreach (HttpMethodsEnum::getValues() as $httpMethod) {
        foreach (HttpSchemeEnum::getValues() as $httpScheme) {
            $data = [
                'host' => 'test.com',
                'method' => $httpMethod,
                'destination' => '127.0.0.1',
                'scheme' => $httpScheme,
                'uri' => '/test-uri',
                'arguments' => ['arg' => 'value'],
                'query' => ['query' => 'value'],
                'cookies' => ['cookie' => 'value'],
                'headers' => ['header' => 'value'],
                'source' => 'source',
            ];
            $routeMatch = new RouteMatch($data);
            expect($routeMatch->getHost())->toBe('test.com')
                ->and($routeMatch->getMethod())->toBe($httpMethod)
                ->and($routeMatch->getDestination())->toBe('127.0.0.1')
                ->and($routeMatch->getScheme())->toBe($httpScheme)
                ->and($routeMatch->getUri())->toBe('/test-uri')
                ->and($routeMatch->getArguments())->toBe(['arg' => 'value'])
                ->and($routeMatch->getQuery())->toBe(['query' => 'value'])
                ->and($routeMatch->getCookies())->toBe(['cookie' => 'value'])
                ->and($routeMatch->getHeaders())->toBe(['header' => 'value'])
                ->and($routeMatch->getSource())->toBe('source');
            $routeMatchArray = $routeMatch->toArray();
            expect($routeMatchArray)->toBe($data);
        }
    }
});

it('should set and get http method', function () {
    foreach (HttpMethodsEnum::getValues() as $httpMethod) {
        $routeMatch = new RouteMatch();
        $routeMatch->setMethod($httpMethod);
        expect($routeMatch->getMethod())->toBe($httpMethod);
    }
});

it('should set and get scheme', function () {
    foreach (HttpSchemeEnum::getValues() as $httpScheme) {
        $routeMatch = new RouteMatch();
        $routeMatch->setScheme($httpScheme);
        expect($routeMatch->getScheme())->toBe($httpScheme);
    }
});

// Do the above for each setter and getter.
// Below are sample tests for the parseFromArray and toArray methods, with basic set of data

it('should parse from array', function () {
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
        'source' => 'source',
    ];
    $routeMatch = new RouteMatch();
    $routeMatch->parseFromArray($data);
    expect($routeMatch->toArray())->toBe($data);
});

it('should return array representation of the object', function () {
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
        'source' => 'source',
    ];
    $routeMatch = new RouteMatch($data);
    expect($routeMatch->toArray())->toBe($data);
});

it('should handle invalid http method and scheme', function () {
    $data = [
        'host' => 'test.com',
        'method' => 'INVALID_METHOD', // Invalid method.
        'destination' => '127.0.0.1',
        'scheme' => 'INVALID_SCHEME', // Invalid scheme.
        'uri' => '/test-uri',
        'arguments' => ['arg' => 'value'],
        'query' => ['query' => 'value'],
        'cookies' => ['cookie' => 'value'],
        'headers' => ['header' => 'value'],
        'source' => 'source',
    ];
    $routeMatch = new RouteMatch();

    // We would expect an error to happen here.
    try {
        $routeMatch->parseFromArray($data);
        expect(true)->toBe(false);
    } catch (\Exception $e) {
        expect(true)->toBe(true);
    }
});

it('should return empty array if no data is set', function () {
    $routeMatch = new RouteMatch();
    expect($routeMatch->toArray())->toBe([
        'host' => '',
        'method' => null,
        'destination' => '',
        'scheme' => null,
        'uri' => '',
        'arguments' => [],
        'query' => [],
        'cookies' => [],
        'headers' => [],
        'source' => '',
    ]);
});