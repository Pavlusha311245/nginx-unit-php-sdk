<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Http\UnitRequest;

interface Uploadable
{
    /**
     * Uploads a file using the specified UnitRequest object.
     *
     * @param UnitRequest $request The UnitRequest object containing the file to be uploaded.
     * @return mixed Returns the result of the upload process.
     */
    public function upload(UnitRequest $request);

    /**
     * Removes the specified unit.
     *
     * @param UnitRequest $request The request object containing the details of the unit to be removed.
     * @return mixed The result of the removal operation.
     */
    public function remove(UnitRequest $request);
}
