<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\{
    HasThreads,
    HasThreadStackSize
};

/**
 * @extends ApplicationAbstract
 */
class PerlApplication extends ApplicationAbstract
{
    use HasThreads;
    use HasThreadStackSize;

    protected string $_type = 'perl';

    /**
     * PSGI script path
     *
     * @var string
     */
    private string $_script;

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->_script;
    }

    /**
     * @param string $script
     */
    public function setScript(string $script): void
    {
        $this->_script = $script;
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

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'script' => $this->getScript(),
                'thread_stack_size' => $this->getThreadStackSize(),
                'threads' => $this->getThreads(),
            ]
        );
    }
}
