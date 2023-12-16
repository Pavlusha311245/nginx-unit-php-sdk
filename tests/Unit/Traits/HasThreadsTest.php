<?php

use UnitPhpSdk\Traits\HasThreads;

it('gets and sets threads correctly', function () {
    $mock = $this->getMockForTrait(HasThreads::class);

    $mock->setThreads(5);
    $this->assertSame(5, $mock->getThreads());

    $mock->setThreads(10);
    $this->assertSame(10, $mock->getThreads());
});
