<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Config\Application\Targets\PhpTarget;
use UnitPhpSdk\Traits\HasTargets;

/**
 * @extends ApplicationAbstract
 */
class PhpApplication extends ApplicationAbstract
{
    use HasTargets;

    protected string $_type = 'php';

    /**
     * @var string
     */
    private string $_root = '';

    /**
     * @var string
     */
    private string $_index = '';

    /**
     * @var string
     */
    private string $_script = '';

    /**
     * @var
     */
    private $_options;

    /**
     * @return mixed
     */
    public function getRoot(): string
    {
        return $this->_root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot(string $root): void
    {
        $this->_root = $root;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->_index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->_index = $index;
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
    public function setScript(string $script = 'index.php'): void
    {
        $this->_script = $script;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options): void
    {
        $this->_options = $options;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (array_key_exists('root', $data)) {
            $this->setRoot($data['root']);
        }

        if (array_key_exists('index', $data)) {
            $this->setIndex($data['index']);
        }

        if (array_key_exists('script', $data)) {
            $this->setScript($data['script']);
        }

        if (array_key_exists('options', $data)) {
            $this->setOptions($data['options']);
        }

        if (array_key_exists('targets', $data)) {
            $targets = [];
            foreach ($data['targets'] as $targetName => $targetData) {
                $targets[$targetName] = new PhpTarget($targetData);
            }

            $this->setTargets($targets);
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'root' => $this->getRoot(),
                'index' => $this->getIndex(),
                'script' => $this->getScript(),
                'options' => $this->getOptions(),
                'targets' => $this->getTargets()
            ]
        );
    }
}
