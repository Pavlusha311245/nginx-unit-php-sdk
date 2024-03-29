<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;

class WebAssemblyComponentApplication extends AbstractApplication
{
    public const array REQUIRED_KEYS = ['component'];

    public const array OPTIONAL_KEYS = ['access'];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'wasm-wasi-component';

    private string $component = '';

    private array $access = [];

    public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (array_key_exists('component', $data)) {
            $this->setComponent($data['component']);
        }

        if (array_key_exists('access', $data)) {
            $this->setAccess($data['access']);
        }
    }

    /**
     * @return string
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @param string $component
     */
    public function setComponent(string $component): void
    {
        $this->component = $component;
    }

    /**
     * @return array
     */
    public function getAccess(): array
    {
        return $this->access;
    }

    /**
     * @param array $access
     */
    public function setAccess(array $access): void
    {
        $this->access = $access;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => self::TYPE,
            'component' => $this->getComponent(),
            'access' => $this->getAccess(),
        ]);
    }
}
