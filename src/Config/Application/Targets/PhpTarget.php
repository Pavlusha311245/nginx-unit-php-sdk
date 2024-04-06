<?php

namespace UnitPhpSdk\Config\Application\Targets;

use UnitPhpSdk\Contracts\Arrayable;

class PhpTarget implements Arrayable
{
    /**
     * Base directory of the app’s file structure. All URI paths are relative to it.
     *
     * @var string
     */
    private string $root;

    /**
     * Filename of a root-based PHP script that serves all requests to the app.
     * If script is set, all requests to the application are handled by the script you specify in this option
     *
     * @var string
     */
    private string $script = 'index.php';

    /**
     * Filename added to URI paths that point to directories if no script is set
     * The requests are served according to their URI paths; if they point to directories, index is used.
     *
     * @var string
     */
    private string $index = 'index.php';

    public function __construct(array $data)
    {
        if (array_key_exists('script', $data)) {
            $this->setScript($data['script']);
        }

        if (array_key_exists('index', $data)) {
            $this->setIndex($data['index']);
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

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @return array
     */
    #[\Override] public function toArray(): array
    {
        return [
            'root' => $this->getRoot(),
            'script' => $this->getScript(),
            'index' => $this->getIndex()
        ];
    }
}
