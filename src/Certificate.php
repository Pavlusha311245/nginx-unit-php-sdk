<?php

namespace UnitPhpSdk;

use InvalidArgumentException;
use Override;
use UnitPhpSdk\Certificate\ChainItem;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\CertificateInterface;

/**
 * Certificate class
 *
 * @implements CertificateInterface
 */
readonly class Certificate implements CertificateInterface, Arrayable
{
    /**
     * @var array $chain
     */
    private array $chain;

    /**
     * @var string|mixed $key
     */
    private string $key;

    public function __construct(
        array          $data,
        private string $name
    ) {
        if (!isset($data['key']) || !isset($data['chain'])) {
            throw new InvalidArgumentException('Certificate data should contain key and chain');
        }

        $chainItems = [];
        foreach ($data['chain'] as $item) {
            $chainItems[] = new ChainItem($item);
        }

        $this->chain = $chainItems;

        $this->key = $data['key'];
    }

    /**
     * Return certificate name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getChain(): array
    {
        return $this->chain;
    }

    #[Override] public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'chain' => $this->getChain(),
        ];
    }
}
