<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\HasThreads;

class RubyApplication extends ApplicationAbstract
{
    use HasThreads;

    private string $_script;
    private string $_hooks;

    /**
     * @param string $script
     */
    public function setScript(string $script): void
    {
        $this->_script = $script;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->_script;
    }

    /**
     * @param string $hooks
     */
    public function setHooks(string $hooks): void
    {
        $this->_hooks = $hooks;
    }

    /**
     * @return string
     */
    public function getHooks(): string
    {
        return $this->_hooks;
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
}
