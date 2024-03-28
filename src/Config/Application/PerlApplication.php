<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\{
    HasThreads,
    HasThreadStackSize
};

/**
 * @extends AbstractApplication
 */
class PerlApplication extends AbstractApplication
{
    use HasThreads;
    use HasThreadStackSize;

    public const array REQUIRED_KEYS = ['script'];

    public const array OPTIONAL_KEYS = ['thread_stack_size', 'threads'];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'perl';

    /**
     * PSGI script path
     *
     * @var string
     */
    private string $script;

    /**
     * @return array
     */
    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $script
     * @return PerlApplication
     */
    public function setScript(string $script): self
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('script', $data)) {
            throw new RequiredKeyException('script');
        }

        $this->setScript($data['script']);

        if (array_key_exists('thread_stack_size', $data)) {
            $this->setThreadStackSize($data['thread_stack_size']);
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
                'type' => self::TYPE,
                'script' => $this->getScript(),
                'thread_stack_size' => $this->getThreadStackSize(),
                'threads' => $this->getThreads(),
            ]
        );
    }
}
