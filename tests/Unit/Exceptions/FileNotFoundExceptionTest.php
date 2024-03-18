<?php

use UnitPhpSdk\Exceptions\FileNotFoundException;

use function PHPUnit\Framework\assertEquals;

it('should throw FileNotFoundException', function () {
    $this->expectException(FileNotFoundException::class);

    throw new FileNotFoundException();
});

it('FileNotFoundException should return correct message', function () {
    try {
        throw new FileNotFoundException();
    } catch (FileNotFoundException $e) {
        assertEquals('Fail to open file', $e->getMessage());
    }
});
