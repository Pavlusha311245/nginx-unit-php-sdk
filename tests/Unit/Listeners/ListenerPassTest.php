<?php

use UnitPhpSdk\Config\Listener\ListenerPass;

it('constructs correctly and getters work', function () {
    $listenerPass = new ListenerPass("application/Home");

    expect($listenerPass->getType())->toBe("application")
        ->and($listenerPass->getName())->toBe("Home")
        ->and($listenerPass->toArray())->toBe(["application", "Home"])
        ->and($listenerPass->toString())->toBe("application/Home");
});

it('constructs correctly with optional name', function () {
    $listenerPass = new ListenerPass("application");

    expect($listenerPass->getType())->toBe("application")
        ->and($listenerPass->getName())->toBeNull()
        ->and($listenerPass->toArray())->toBe(["application"])
        ->and($listenerPass->toString())->toBe("application");
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
