<?php

namespace UnitPhpSdk\Config\Listener;

use UnitPhpSdk\Certificate;
use UnitPhpSdk\Exceptions\UnitException;

class Tls
{
    private string|array $_certificate;

    private array $_conf_commands = [];

    private array $_session = [];

    /**
     * @throws UnitException
     */
    public function __construct(array $data = [])
    {
        $this->parseFromArray($data);
    }

    /**
     * @param array $data
     */
    private function parseFromArray(array $data): void
    {
        //        if (empty($data['certificate'])) {
        //            throw new UnitException("Missing required 'source' array key");
        //        }

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
        $this->_certificate = $certificate;
    }

    /**
     * @return array|string
     */
    public function getCertificate(): string|array
    {
        return $this->_certificate;
    }

    /**
     * @param array $session
     */
    public function setSession(array $session): void
    {
        $this->_session = $session;
    }

    /**
     * @return array
     */
    public function getSession(): array
    {
        return $this->_session;
    }

    /**
     * @param array $conf_commands
     */
    public function setConfCommands(array $conf_commands): void
    {
        $this->_conf_commands = $conf_commands;
    }

    /**
     * @return array
     */
    public function getConfCommands(): array
    {
        return $this->_conf_commands;
    }

    /**
     * @return array[]|string[]
     */
    public function toArray(): array
    {
        $data = [
            'certificate' => $this->_certificate
        ];

        if (!empty($this->getSession())) {
            $data['session'] = $this->getSession();
        }

        if (!empty($this->getConfCommands())) {
            $data['conf_commands'] = $this->getConfCommands();
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
