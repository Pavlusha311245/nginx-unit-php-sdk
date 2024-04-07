<?php

namespace UnitPhpSdk\Certificate;

use UnitPhpSdk\Contracts\Arrayable;

class ChainItem implements Arrayable
{
    /**
     * @var array|mixed $subjet
     */
    private array $subjet;

    /**
     * @var array|mixed $issuer
     */
    private array $issuer;

    /**
     * Holds the validity information for the current object.
     *
     * @var array|mixed
     */
    private array $validity;

    public function __construct(array $data)
    {
        $this->subjet = $data['subject'];
        $this->issuer = $data['issuer'];
        $this->validity = $data['validity'];
    }

    /**
     * @return array
     */
    public function getSubject(): array
    {
        return $this->subjet;
    }

    /**
     * @return array
     */
    public function getIssuer(): array
    {
        return $this->issuer;
    }

    /**
     * Retrieves the validity of the object.
     *
     * @return array The array containing the validity information.
     */
    public function getValidity(): array
    {
        return $this->validity;
    }

    #[\Override] public function toArray(): array
    {
        return [
            'subject' => $this->subjet,
            'issuer' => $this->issuer,
            'validity' => $this->validity,
        ];
    }
}
