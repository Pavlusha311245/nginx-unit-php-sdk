<?php

use UnitPhpSdk\Config\Listener\Tls;

it('Initializes with correct properties from array', function () {
    $data = [
        'certificate' => 'cert_value',
        'conf_commands' => ['command1', 'command2'],
        'session' => ['session_data']
    ];

    $tls = new Tls($data);
    expect($tls->getCertificate())->toBe($data['certificate'])
        ->and($tls->getConfCommands())->toBe($data['conf_commands'])
        ->and($tls->getSession())->toBe($data['session']);
});

it('Converts to array with correct properties', function () {
    $data = [
        'certificate' => 'cert_value',
        'conf_commands' => ['command1', 'command2'],
        'session' => ['session_data']
    ];

    $tls = new Tls($data);
    expect($tls->toArray())->toBe($data);
});

it('Converts to json correctly', function () {
    $data = [
        'certificate' => 'cert_value',
        'conf_commands' => ['command1', 'command2'],
        'session' => ['session_data']
    ];

    $tls = new Tls($data);
    expect($tls->toJson())->toBe(json_encode($data));
});
