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

    public const array REQUIRED_KEYS = ['script'];

    public const array OPTIONAL_KEYS = ['hooks', 'threads'];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'ruby';

    /**
     * @var string
     */
    private string $script = '';

    /**
     * @var string
     */
    private string $hooks = '';

    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

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
    #[\Override] public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => self::TYPE,
                'script' => $this->getScript(),
                'hooks' => $this->getHooks(),
                'threads' => $this->getThreads()
            ]
        );
    }
}
