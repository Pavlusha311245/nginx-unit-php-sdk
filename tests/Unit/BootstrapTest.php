<?php

use Pavlusha311245\UnitPhpSdk\Unit;

const SOCKET = '/usr/local/var/run/unit/control.sock';
const ADDRESS = 'http://localhost';

test('Can create unit object', function () {
    expect(new Unit(
        socket: SOCKET,
        address: ADDRESS
    ))->toBeObject();
});
