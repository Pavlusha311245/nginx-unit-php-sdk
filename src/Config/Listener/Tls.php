<?php

namespace UnitPhpSdk\Config\Listener;

class Tls
{
    /**
     * Refers to one or more certificate bundles uploaded earlier, enabling secure communication via the listener.
     *
     * @var string|array
     */
    private string|array $certificate;

    /**
     * Defines the OpenSSL configuration commands to be set for the listener.
     *
     * @var array
     */
    private array $conf_commands = [];

    /**
     * Configures the TLS session cache and tickets for the listener.
     *
     * @var array
     */
    private array $session = [];

    public function __construct(array $data = [])
    {
        $this->parseFromArray($data);
    }

    /**
     * @param array $data
     */
    private function parseFromArray(array $data): void
    {
        if (array_key_exists('certificate', $data)) {
            $this->setCertificate($data['certificate']);
        }

        if (array_key_exists('conf_commands', $data)) {
            $this->setConfCommands($data['conf_commands']);
        }

        if (array_key_exists('session', $data)) {
            $this->setSession($data['session']);
        }
    }

    /**
     * @param string|array $certificate
     */
    public function setCertificate(string|array $certificate): void
    {
        $this->certificate = $certificate;
    }

    /**
     * @return array|string
     */
    public function getCertificate(): string|array
    {
        return $this->certificate;
    }

    /**
     * @param array $session
     */
    public function setSession(array $session): void
    {
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getSession(): array
    {
        return $this->session;
    }

    /**
     * @param array $conf_commands
     */
    public function setConfCommands(array $conf_commands): void
    {
        $this->conf_commands = $conf_commands;
    }

    /**
     * @return array
     */
    public function getConfCommands(): array
    {
        return $this->conf_commands;
    }

    /**
     * @return array[]|string[]
     */
    public function toArray(): array
    {
        $data = [
            'certificate' => $this->certificate
        ];

        if (!empty($this->getConfCommands())) {
            $data['conf_commands'] = $this->getConfCommands();
        }

        if (!empty($this->getSession())) {
            $data['session'] = $this->getSession();
        }

        return $data;
    }

    /**
     * @return false|string
     */
    public function toJson(): false|string
    {
        return json_encode($this->toArray());
    }
}
