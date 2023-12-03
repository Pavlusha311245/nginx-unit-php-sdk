<?php

namespace UnitPhpSdk\Config\Listener;

use UnitPhpSdk\Contracts\Arrayable;

readonly class ListenerPass implements Arrayable
{
    /**
     * @var string
     */
    private string $type;

    private ?string $name;

    public function __construct(private string $data)
    {
        $this->type = explode('/', $data)[0];
        $this->name = explode('/', $data)[1] ?? null;
    }


    /**
     * Return pass type (application, routes, route, upstreams)
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Return pass as string
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->data;
    }

    /**
     * Return pass as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return explode('/', $this->data);
    }
}
