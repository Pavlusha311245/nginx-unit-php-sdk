<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Application\Targets\PhpTarget;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\HasTargets;

/**
 * @extends AbstractApplication
 */
class PhpApplication extends AbstractApplication
{
    use HasTargets;

    public const TYPE = 'php';

    /**
     * @var string
     */
    private string $root = '';

    /**
     * @var string
     */
    private string $index = '';

    /**
     * @var string
     */
    private string $script = '';

    /**
     * @var
     */
    private $options;

    /**
     * @return mixed
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @param string $root
     * @return PhpApplication
     */
    public function setRoot(string $root): self
    {
        $this->root = $root;

        return $this;
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
     * @return PhpApplication
     */
    public function setIndex(string $index): self
    {
        $this->index = $index;

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
     * @param string $script
     */
    public function setScript(string $script = 'index.php'): self
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions(): mixed
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     * @return PhpApplication
     */
    public function setOptions(mixed $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('root', $data) && !array_key_exists('targets', $data)) {
            throw new RequiredKeyException('root', 'targets');
        }

        if (array_key_exists('root', $data)) {
            $this->setRoot($data['root']);
        }

        if (array_key_exists('targets', $data)) {
            $targets = [];
            foreach ($data['targets'] as $targetName => $targetData) {
                $targets[$targetName] = new PhpTarget($targetData);
            }

            $this->setTargets($targets);
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
