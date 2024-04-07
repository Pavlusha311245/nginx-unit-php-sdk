<?php

use PHPUnit\Framework\TestCase;

use UnitPhpSdk\Config\Application\ProcessManagement\ApplicationProcess;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

it('checks max on ApplicationProcess', function () {
    $applicationProcess = new ApplicationProcess(['max' => 5]);
    assertEquals(5, $applicationProcess->getMax());
});

it('checks spare on ApplicationProcess', function () {
    $applicationProcess = new ApplicationProcess(['spare' => 3]);
    assertEquals(3, $applicationProcess->getSpare());
});

it('checks idle_timeout on ApplicationProcess', function () {
    $applicationProcess = new ApplicationProcess(['idle_timeout' => 10]);
    assertEquals(10, $applicationProcess->getIdleTimeout());
});

it('checks toArray on ApplicationProcess', function () {
    $applicationProcess = new ApplicationProcess(['max' => 5, 'spare' => 3, 'idle_timeout' => 10]);
    $expectedArray = ['max' => 5, 'spare' => 3, 'idle_timeout' => 10];
    assertSame($expectedArray, $applicationProcess->toArray());
});
