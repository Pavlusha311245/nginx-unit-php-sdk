<?php
use \UnitPhpSdk\Config\Routes\RouteBlock;
use \UnitPhpSdk\Config\Routes\RouteAction;
use \UnitPhpSdk\Config\Routes\RouteMatch;
use \UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Enums\HttpSchemeEnum;

it('RouteBlock class functions correctly', function () {
    $routeActionData = [
        'pass' => 'pass',
        'proxy' => 'proxy',
        'return' => 201,
        'location' => 'http://mock-location',
        'share' => '/var/mock',
        'index' => 'index.html',
        'chroot' => '/var/mock-root',
        'types' => ['html' => 'text/html'],
        'fallback' => ['pass' => 'fallback'],
        'follow_symlinks' => true,
        'traverse_mounts' => true,
    ];

    $routeMatchData = [
        'host' => 'mock-host',
        'method' => HttpMethodsEnum::GET,
        'source' => '/\source',
        'destination' => 'mock-destination',
        'scheme' => HttpSchemeEnum::HTTP,
        'uri' => '/path/to/file',
        'arguments' => ['arg1' => '1'],
        'query' => ['query' => 'mock-query'],
        'cookies' => ['cookie1' => 'yum'],
        'headers' => ['Accept' => 'application/json'],
    ];

    $routeBlock = new RouteBlock([
        'action' => $routeActionData,
        'match' => $routeMatchData,
    ]);

    // test getters and setters
    $newRouteAction = new RouteAction($routeActionData);
    $newRouteMatch = new RouteMatch($routeMatchData);

    $routeBlock->setAction($newRouteAction);
    $routeBlock->setMatch($newRouteMatch);

    $this->assertEquals($newRouteAction, $routeBlock->getAction());
    $this->assertEquals($newRouteMatch, $routeBlock->getMatch());

    // TODO: fix
    // test toArray function
//    $toArrayResult = $routeBlock->toArray();
//
//    $this->assertEquals($routeActionData, $toArrayResult['action']);
//    $this->assertEquals($routeMatchData, $toArrayResult['match']);
});
