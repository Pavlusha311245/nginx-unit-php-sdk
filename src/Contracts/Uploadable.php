<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Http\UnitRequest;

interface Uploadable
{
    public function upload(UnitRequest $request);
}
