<?php

namespace Tests\Unit;

use UnitPhpSdk\Config\Listener;

test('Listener can be created', function () {
    expect(new Listener('*:80', 'routes'))->toBeObject();
});
