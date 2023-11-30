<?php

namespace UnitPhpSdk\Config\Application\Targets;

class PhpTarget
{
    /**
     * Base directory of the app’s file structure. All URI paths are relative to it.
     *
     * @var string
     */
    private string $root;

    /**
     * Filename of a root-based PHP script that serves all requests to the app.
     *
     * @var string
     */
    private string $script = 'index.php';

    public function __construct(array $data)
    {
        if (array_key_exists('script', $data)) {
            $this->setScript($data['script']);
        }

        $this->setRoot($data['root']);
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
     */
    public function setScript(string $script): void
    {
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @param string $root
     */
    public function setRoot(string $root): void
    {
        $this->root = $root;
    }
}
