<?php

use UnitPhpSdk\Certificate;
use UnitPhpSdk\Certificate\ChainItem;
use PHPUnit\Framework\Assert;

$data = [
    'key' => 'testKey',
    'chain' => [
        [
            'subject' =>
                ['country' => 'TS', 'state_or_province' => 'Test', 'organization' => 'Test'],
            'issuer' =>
                ['country' => 'TS', 'state_or_province' => 'Test', 'organization' => 'Test'],
            'validity' => ['since' => 'Mar 27 19:09:20 2024 GMT', 'until' => 'Mar 27 19:09:20 2024 GMT']
        ]
    ]
];

it('can get the certificate name', function () use ($data) {
    $certificate = new Certificate($data, 'testName');
    Assert::assertEquals('testName', $certificate->getName());
});

it('can get the certificate key', function () use ($data) {
    $certificate = new Certificate($data, 'testName');
    Assert::assertEquals('testKey', $certificate->getKey());
});

it('can get the certificate chain', function () use ($data) {
    $expectedChain = array_map(fn ($item) => new ChainItem($item), $data['chain']);
    $certificate = new Certificate($data, 'testName');
    Assert::assertEquals($expectedChain, $certificate->getChain());
});

// TODO: fix this test
//it('can get the certificate data as array', function () use ($data) {
//    $expectedArray = [
//        'key' => 'testKey',
//        'chain' => array_map(fn ($item) => (new ChainItem($item))->toArray(), $data['chain'])
//    ];
//    $certificate = new Certificate($expectedArray, 'testName');
//    Assert::assertEquals($expectedArray, $certificate->toArray());
//});
