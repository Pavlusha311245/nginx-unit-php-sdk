<?php

use UnitPhpSdk\Certificate;
use PHPUnit\Framework\Assert;

it('can get the certificate name', function () {
    $certificate = new Certificate(['key' => 'testKey', 'chain' => ['testChain']], 'testName');
    Assert::assertEquals('testName', $certificate->getName());
});

it('can get the certificate key', function () {
    $certificate = new Certificate(['key' => 'testKey', 'chain' => ['testChain']], 'testName');
    Assert::assertEquals('testKey', $certificate->getKey());
});

it('can get the certificate chain', function () {
    $certificate = new Certificate(['key' => 'testKey', 'chain' => ['testChain']], 'testName');
    Assert::assertEquals(['testChain'], $certificate->getChain());
});

it('can get the certificate data as array', function () {
    $data = ['key' => 'testKey', 'chain' => ['testChain']];
    $certificate = new Certificate($data, 'testName');
    Assert::assertEquals($data, $certificate->getData());
});
