<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

/**
 * Application class
 */
class Application
{
    private string $_type;

    private array $_environment;

    private string $_group;

    private string $_user;

    private string $_working_directory;

    private string $_name;

    private string $_stderr = '/dev/null';

    private string $_stdout = '/dev/null';

    private $_processes;

    private $_limits;

    private $_isolation;

    private $_data;

    private array $_arguments = [];

    private array $_listeners = [];

    public function __construct($applicationName, $applicationData)
    {
        $this->_name = $applicationName;
        $this->_type = $applicationData['type'];
        $this->_data = $applicationData;

        foreach ($this->_data as $key => $value) {
            $this->{"_{$key}"} = $value;
        }
    }

    /**
     * Get application arguments
     *
     * @return array
     */
    public function getArguments(): array
    {
        return array_values($this->_arguments);
    }

    /**
     * Get application type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * Set application listener
     *
     * @param mixed $listener
     */
    public function setListener(Listener $listener): void
    {
        $this->_listeners[$listener->getListener()] = $listener;
    }

    /**
     * Return listener
     *
     * @return array
     */
    public function getListeners(): array
    {
        return $this->_listeners;
    }

    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->_user;
    }

    /**
     * Get group
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->_group;
    }
}
