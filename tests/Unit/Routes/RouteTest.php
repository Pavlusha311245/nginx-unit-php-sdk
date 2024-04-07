<?php

use UnitPhpSdk\Config\Route;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\RouteInterface;
use UnitPhpSdk\Config\Routes\RouteBlock;

it('checks interface implementation', function () {
    $route = new Route('test', [], false);
    expect($route)->toBeInstanceOf(RouteInterface::class)
        ->and($route)->toBeInstanceOf(Arrayable::class);
});

it('route name matches the given one', function () {
    $route = new Route('test', [], false);
    expect($route->getName())->toBe('test');
});

it('route blocks array is empty on initialization with empty data', function () {
    $route = new Route('test', [], false);
    expect($route->getRouteBlocks())->toBeArray()->toBeEmpty();
});

it('route blocks array is not empty when initialized with data', function () {
    $data = [
        [
            'name' => 'block1',
            'action' => ['action1'],
            'match' => ['match1']
        ],
        [
            'name' => 'block2',
            'action' => ['action2'],
            'match' => ['match2']
        ],
    ];
    $route = new Route('test', $data, false);
    expect($route->getRouteBlocks())->toBeArray()->not->toBeEmpty()->toHaveCount(2);

    foreach ($route->getRouteBlocks() as $routeBlock) {
        expect($routeBlock)->toBeInstanceOf(RouteBlock::class);
    }

});

it('toJson should return a json string', function () {
    $data = [
        [
            'name' => 'block1',
            'action' => ['action1'],
            'match' => ['match1']
        ],
    ];
    $route = new Route('test', $data, false);
    expect($route->toJson())->toBeJson();
});
