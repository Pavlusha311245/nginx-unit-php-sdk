<?php

namespace UnitPhpSdk\Config\Application;

use InvalidArgumentException;
use Override;
use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Application\Options\PhpOptions;
use UnitPhpSdk\Config\Application\Targets\PhpTarget;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\HasTargets;

/**
 * @extends AbstractApplication
 */
class PhpApplication extends AbstractApplication implements Arrayable
{
    use HasTargets;

    /**
     * @var array
     */
    public const array REQUIRED_KEYS = ['root'];

    public const array OPTIONAL_KEYS = ['index', 'script', 'options', 'targets'];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'php';

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
     * @var PhpOptions|null
     */
    private ?PhpOptions $options = null;

    /**
     * @return array|string[]
     */
    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

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

        $data = array_filter($data, fn ($value) => !empty($value));

        if (array_key_exists('root', $data)) {
            if (!is_string($data['root'])) {
                throw new InvalidArgumentException('root must be a string');
            }

            $this->setRoot($data['root']);
        }

        if (array_key_exists('targets', $data)) {
            $targets = [];
            foreach ($data['targets'] as $targetName => $targetData) {
                if (!is_array($targetData)) {
                    throw new InvalidArgumentException('target data must be an array');
                }

                if (!array_key_exists('root', $targetData)) {
                    throw new RequiredKeyException('root');
                }

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

    /**
     * @inheritDoc
     */
    #[Override] public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => self::TYPE,
                'root' => $this->getRoot(),
                'index' => $this->getIndex(),
                'script' => $this->getScript(),
                'options' => $this->getOptions(),
                'targets' => array_map(fn (PhpTarget $target) => $target->toArray(), $this->getTargets() ?? [])
            ]
        );
    }
}
