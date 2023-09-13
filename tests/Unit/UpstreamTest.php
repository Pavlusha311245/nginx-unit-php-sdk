<?php

use UnitPhpSdk\Config\Upstream;

test('Upstream object can be created', function () {
    $upstream = new Upstream('test');
    $upstream->setServer('127.0.0.1');

    expect($upstream)->toBeObject();
});
