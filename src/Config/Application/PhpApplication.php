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
    private ?PhpOptions $options;

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
    public function setIndex(string $index = 'index.php'): self
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
     * @return PhpApplication
     */
    public function setScript(string $script = 'index.php'): self
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return PhpOptions|null
     */
    public function getOptions(): ?PhpOptions
    {
        return $this->options;
    }

    /**
     * @param array $optionsData
     * @return PhpApplication
     */
    public function setOptions(array $optionsData): self
    {
        $options = new PhpOptions();

        if (array_key_exists('admin', $optionsData)) {
            $options->setAdmin($optionsData['admin']);
        }

        if (array_key_exists('user', $optionsData)) {
            $options->setUser($optionsData['user']);
        }

        if (array_key_exists('file', $optionsData) && is_string($optionsData['file'])) {
            $options->setFile($optionsData['file']);
        }

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
