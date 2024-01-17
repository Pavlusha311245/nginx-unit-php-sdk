<?php

use UnitPhpSdk\Config\Listener\ListenerPass;

it('constructs correctly and getters work', function () {
    $listenerPass = new ListenerPass("applications/Home");

    expect($listenerPass->getType())->toBe("applications")
        ->and($listenerPass->getName())->toBe("Home")
        ->and($listenerPass->toArray())->toBe(["applications", "Home"])
        ->and($listenerPass->toString())->toBe("applications/Home");
});

it('getType returns the correct type', function () {
    $listenerPass = new ListenerPass("routes/Home");

    expect($listenerPass->getType())->toBe("routes");
});

it('getName returns the correct name', function () {
    $listenerPass = new ListenerPass("routes/Home");

    expect($listenerPass->getName())->toBe("Home");
});

it('toString returns the correct string', function () {
    $listenerPass = new ListenerPass("routes/Home");

    expect($listenerPass->toString())->toBe("routes/Home");
});

it('toArray returns the correct array', function () {
    $listenerPass = new ListenerPass("routes/Home");

    expect($listenerPass->toArray())->toBe(["routes", "Home"]);
});
