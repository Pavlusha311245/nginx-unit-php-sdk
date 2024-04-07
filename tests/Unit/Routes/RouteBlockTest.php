<?php

use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Config\Routes\RouteAction;
use UnitPhpSdk\Config\Routes\RouteMatch;
use UnitPhpSdk\Config\Routes\ActionType\PassAction;
use UnitPhpSdk\Config\Routes\ActionType\ProxyAction;
use UnitPhpSdk\Config\Routes\ActionType\ShareAction;
use UnitPhpSdk\Config\Routes\ActionType\ReturnAction;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Enums\HttpSchemeEnum;
use function PHPUnit\Framework\assertEquals;

// TODO: fix this test
//it('RouteBlock class functions correctly', function () {
//    $routeActionData = [
//        'pass' => new PassAction('pass'),
//        'proxy' => new ProxyAction('proxy'),
//        'return' => new ReturnAction(201),
//        'share' => new ShareAction('/var/mock'),
//        'follow_symlinks' => true,
//        'traverse_mounts' => true,
//        'response_headers' => [
//            "CDN-Cache-Control" => "max-age=600"
//        ],
//        'rewrite' => null
//    ];
//
//    $routeMatchData = [
//        'host' => 'mock-host',
//        'method' => HttpMethodsEnum::GET,
//        'source' => '/\source',
//        'destination' => 'mock-destination',
//        'scheme' => HttpSchemeEnum::HTTP,
//        'uri' => '/path/to/file',
//        'arguments' => ['arg1' => '1'],
//        'query' => ['query' => 'mock-query'],
//        'cookies' => ['cookie1' => 'yum'],
//        'headers' => ['Accept' => 'application/json'],
//    ];
//
//    $routeBlock = new RouteBlock([
//        'action' => new RouteAction($routeActionData),
//        'match' => new RouteMatch($routeMatchData),
//    ]);
//
//    // test getters and setters
//    $newRouteAction = new RouteAction($routeActionData);
//    $newRouteMatch = new RouteMatch($routeMatchData);
//
//    $routeBlock->setAction($newRouteAction);
//    $routeBlock->setMatch($newRouteMatch);
//
//    assertEquals($newRouteAction, $routeBlock->getAction());
//    assertEquals($newRouteMatch, $routeBlock->getMatch());
//
//    // test toArray function
//    $toArrayResult = $routeBlock->toArray();
//
//    assertEquals($routeActionData, $toArrayResult['action']->toArray());
//    assertEquals($routeMatchData, $toArrayResult['match']->toArray());
//});