<?php

it('throws UnitException', function () {
    $this->expectException(UnitPhpSdk\Exceptions\UnitException::class);

    // Replace this line with the code that is expected to throw an exception
    throw new UnitPhpSdk\Exceptions\UnitException();
});

it('has empty message', function () {
    try {
        // Replace this line with the code that is expected to throw an exception
        throw new UnitPhpSdk\Exceptions\UnitException();
    } catch (UnitPhpSdk\Exceptions\UnitException $e) {
        $this->assertSame('', $e->getMessage());
    }
});
