<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\Targets;

class PhpTarget
{
    /**
     * Base directory of the app’s file structure. All URI paths are relative to it.
     *
     * @var string
     */
    private string $_root;

    /**
     * Filename of a root-based PHP script that serves all requests to the app.
     *
     * @var string
     */
    private string $_script;

    public function __construct(array $data)
    {
        $this->setRoot($data['root']);
        $this->setScript($data['script']);
    }

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
     * @return string
     */
    public function getRoot(): string
    {
        return $this->_root;
    }

    /**
     * @param string $root
     */
    public function setRoot(string $root): void
    {
        $this->_root = $root;
    }
}
