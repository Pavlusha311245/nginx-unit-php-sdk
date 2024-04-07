<?php

use PHPUnit\Framework\TestCase;
use UnitPhpSdk\Config\Routes\RouteAction;
use UnitPhpSdk\Config\Routes\ActionType\PassAction;
use UnitPhpSdk\Config\Routes\ActionType\ProxyAction;
use UnitPhpSdk\Config\Routes\ActionType\ReturnAction;
use UnitPhpSdk\Config\Routes\ActionType\ShareAction;
use UnitPhpSdk\Exceptions\UnitException;

use function PHPUnit\Framework\assertEquals;

// TODO: fix this test
//it('test RouteAction setters and getters', function () {
//    $data = [
//        'pass' => new PassAction('from_here'),
//        'response_headers' => [],
//        'proxy' => new ProxyAction('to_there'),
//        'return' => new ReturnAction(200),
//        'rewrite' => 'rewrite_this',
//        'share' => new ShareAction('share_this'),
//    ];
//
//    $routeAction = new RouteAction($data);
//
//    assertEquals($data['pass'], $routeAction->getPass());
//    assertEquals($data['response_headers'], $routeAction->getResponseHeaders());
//    assertEquals($data['proxy'], $routeAction->getProxy());
//    assertEquals($data['return'], $routeAction->getReturn());
//    assertEquals($data['rewrite'], $routeAction->getRewrite());
//    assertEquals($data['share'], $routeAction->getShare());
//});
//
//it(/**
// * @throws UnitException
// */ 'test toArray method', function () {
//    $data = [
//        'pass' => new PassAction('from_here'),
//        'response_headers' => [],
//        'proxy' => 'to_there',
//        'return' => new ReturnAction(200),
//        'rewrite' => 'rewrite_this',
//        'share' => new ShareAction('share_this'),
//        'follow_symlinks' => true,
//        'traverse_mounts' => true,
//    ];
//
//    $routeAction = new RouteAction($data);
//
//    assertEquals($data, $routeAction->toArray());
//});

it('test setReturn throws exception for value greater than 999', function () {
    $routeAction = new RouteAction();
    $routeAction->setReturn(new ReturnAction(1000));
})->throws(OutOfRangeException::class);

it('test setReturn throws exception for value less than 0', function () {
    $routeAction = new RouteAction();
    $routeAction->setReturn(new ReturnAction(-1));
})->throws(OutOfRangeException::class);
