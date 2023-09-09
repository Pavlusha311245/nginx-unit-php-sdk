<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Traits\{
    HasThreads,
    HasThreadStackSize
};

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
            throw new UnitException('Script key is required');
        }

        $this->setScript($data['script']);

        if (array_key_exists('thread_stack_size', $data)) {
            $this->setThreadStackSize($data['thread_stack_size']);
        }

        if (array_key_exists('threads', $data)) {
            $this->setThreads($data['threads']);
        }
    }
}
