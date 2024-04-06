<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;

class JsModule implements Arrayable, Jsonable
{
    public function __construct(
        private string $name = '',
        private string $content = ''
    ) {
        //
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    #[\Override] public function toArray(): array
    {
        return [
            $this->name => $this->content,
        ];
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
