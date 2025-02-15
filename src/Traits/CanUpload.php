<?php

namespace UnitPhpSdk\Traits;

use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;

trait CanUpload
{
    public string $api_endpoint = '';

    /**
     * @param string $api_endpoint
     */
    public function setApiEndpoint(string $api_endpoint): void
    {
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->api_endpoint;
    }

    protected function removeEmptyArrays($array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->removeEmptyArrays($value);
            }
            if (!empty($value)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @throws UnitException
     */
    public function upload(UnitRequest $request)
    {
        $data = $this->removeEmptyArrays($this->toArray());

        try {
            $request->setMethod(HttpMethodsEnum::PUT)->send(
                $this->getApiEndpoint(),
                true,
                ['json' => $data]
            );
        } catch (UnitException $e) {
            throw new UnitException($e->getMessage());
        }
    }

    /**
     * @param UnitRequest $request
     * @return void
     * @throws UnitException
     */
    public function remove(UnitRequest $request)
    {
        try {
            $request->setMethod(HttpMethodsEnum::DELETE)->send($this->getApiEndpoint());
        } catch (UnitException $e) {
            throw new UnitException($e->getMessage());
        }
    }
}
