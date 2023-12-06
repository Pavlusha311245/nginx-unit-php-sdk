<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\HasThreads;

/**
 * @extends AbstractApplication
 */
class RubyApplication extends AbstractApplication
{
    use HasThreads;

    public const string TYPE = 'ruby';

    /**
     * @var string
     */
    private string $script;

    /**
     * @var string
     */
    private string $hooks;

    /**
     * @param string $script
     * @return RubyApplication
     */
    public function setScript(string $script): self
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $hooks
     * @return RubyApplication
     */
    public function setHooks(string $hooks): self
    {
        $this->hooks = $hooks;

        return $this;
    }

    /**
     * @return string
     */
    public function getHooks(): string
    {
        return $this->hooks;
    }

    /**
     * @inheritDoc
     */
    public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('script', $data)) {
            throw new RequiredKeyException('script');
        }

        $this->setScript($data['script']);

        if (array_key_exists('hooks', $data)) {
            $this->setHooks($data['hooks']);
        }

        if (array_key_exists('threads', $data)) {
            $this->setThreads($data['threads']);
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'script' => $this->getScript(),
                'hooks' => $this->getHooks(),
                'threads' => $this->getThreads()
            ]
        );
    }
}
