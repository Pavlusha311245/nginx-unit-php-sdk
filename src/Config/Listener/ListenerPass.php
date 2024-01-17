<?php

namespace UnitPhpSdk\Config\Listener;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;

readonly class ListenerPass implements Arrayable, Jsonable
{
    /**
     * Listener type (application, routes, route, upstreams)
     *
     * @var string
     */
    private string $type;

    /**
     * Listener name
     *
     * @var string|null
     */
    private ?string $name;

    /**
     * Listener target
     *
     * @var string|null
     */
    private ?string $target;


    public function __construct(private string $data)
    {
        parse_listener_pass($data);

        $this->type = explode('/', $data)[0];
        $this->name = explode('/', $data)[1] ?? null;
        $this->target = explode('/', $data)[2] ?? null;
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
     * Get pass name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get pass target
     *
     * @return string|null
     */
    public function getTarget(): ?string
    {
        return $this->target;
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

    /**
     * @inheritDoc
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
