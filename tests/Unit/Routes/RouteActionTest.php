<?php

use UnitPhpSdk\Config\Routes\RouteAction;
use UnitPhpSdk\Exceptions\UnitException;

use function PHPUnit\Framework\assertEquals;

it('test RouteAction setters and getters', function () {
    $data = [
        'pass' => 'from_here',
        'response_headers' => [],
        'proxy' => 'to_there',
        'return' => 200,
        'location' => 'location_string',
        'rewrite' => 'rewrite_this',
        'share' => 'share_this',
        'index' => 'index_this',
        'chroot' => 'change_root',
        'types' => ['type1', 'type2'],
        'fallback' => ['pass' => 'anywhere', 'proxy' => 'over_here'],
        'follow_symlinks' => true,
        'traverse_mounts' => true,
    ];

    $routeAction = new RouteAction($data);

    assertEquals($data['pass'], $routeAction->getPass());
    assertEquals($data['response_headers'], $routeAction->getResponseHeaders());
    assertEquals($data['proxy'], $routeAction->getProxy());
    assertEquals($data['return'], $routeAction->getReturn());
    assertEquals($data['location'], $routeAction->getLocation());
    assertEquals($data['rewrite'], $routeAction->getRewrite());
    assertEquals($data['share'], $routeAction->getShare());
    assertEquals($data['index'], $routeAction->getIndex());
    assertEquals($data['chroot'], $routeAction->getChroot());
    assertEquals($data['types'], $routeAction->getTypes());
    assertEquals($data['fallback'], $routeAction->getFallback());
    assertEquals($data['follow_symlinks'], $routeAction->isFollowSymlinks());
    assertEquals($data['traverse_mounts'], $routeAction->isTraverseMounts());
});

it(/**
 * @throws UnitException
 */ 'test toArray method', function () {
    $data = [
        'pass' => 'from_here',
        'response_headers' => [],
        'proxy' => 'to_there',
        'return' => 200,
        'location' => 'location_string',
        'rewrite' => 'rewrite_this',
        'share' => 'share_this',
        'index' => 'index_this',
        'chroot' => 'change_root',
        'types' => ['type1', 'type2'],
        'fallback' => ['pass' => 'anywhere', 'proxy' => 'over_here'],
        'follow_symlinks' => true,
        'traverse_mounts' => true,
    ];

    $routeAction = new RouteAction($data);

    assertEquals($data, $routeAction->toArray());
});

it('test setReturn throws exception for value greater than 999', function () {
    $routeAction = new RouteAction();
    $routeAction->setReturn(1000);
})->throws(OutOfRangeException::class);

it('test setReturn throws exception for value less than 0', function () {
    $routeAction = new RouteAction();
    $routeAction->setReturn(-1);
})->throws(OutOfRangeException::class);

it('test setFallback throws exception', function () {
    $routeAction = new RouteAction();
    $routeAction->setFallback([]);
})->throws(UnitException::class);
