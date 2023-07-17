<?php

namespace Pavlusha311245\UnitPhpSdk\Abstract;

use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ApplicationProcess;
use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;
use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\RequestLimit;
use Pavlusha311245\UnitPhpSdk\Enums\ApplicationTypeEnum;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Interfaces\ApplicationInterface;

abstract class ApplicationAbstract implements ApplicationInterface
{
    private string $_type;

    /**
     * Environment variables to be passed to the app
     *
     * @var array
     */
    private array $_environment;

    /**
     * Group name that runs the app process
     *
     * @var string
     */
    protected string $_group;

    /**
     * Username that runs the app process
     *
     * @var string
     */
    protected string $_user;

    /**
     * The app working directory.
     *
     * @var string
     */
    private string $_working_directory;

    private string $_name;

    /**
     * The file path to which Unit redirects the application's error stream output in --no-daemon mode.
     *
     * @var string
     */
    private string $_stderr = '/dev/null';

    /**
     * The file path to which Unit redirects the output of the application output stream in --no-daemon mode.
     *
     * @var string
     */
    private string $_stdout = '/dev/null';

    /**
     * Static number of app processes or object options
     *
     * @var ApplicationProcess|string
     */
    private ApplicationProcess|string $_processes;

    private RequestLimit $_limits;

    private ProcessIsolation $_isolation;

    public function __construct(array $data = null)
    {
        if (!empty($data)) {
            $this->parseFromArray($data);
        }
    }

    public function getType(): string
    {
        return $this->_type;
    }

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    public function getGroup(): string
    {
        return $this->_group;
    }

    public function setGroup(string $name): void
    {
        $this->_group = $name;
    }

    public function getUser(): string
    {
        return $this->_user;
    }

    public function setUser(string $name): void
    {
        $this->_user = $name;
    }

    public function getEnvironment(): array
    {
        return $this->_environment;
    }

    public function setEnvironment(array $environment): void
    {
        foreach ($environment as $key => $value) {
            if (!is_string($value)) {
                throw new UnitException('Parse Exception');
            }
        }

        $this->_environment = $environment;
    }

    public function getIsolation(): ProcessIsolation
    {
        return $this->_isolation;
    }

    public function setIsolation(ProcessIsolation $isolation): void
    {
        $this->_isolation = $isolation;
    }

    public function getProcesses(): ApplicationProcess|int
    {
        return $this->_processes;
    }

    public function setProcesses(ApplicationProcess|int $processes): void
    {
        $this->_processes = $processes;
    }

    public function getLimits(): RequestLimit
    {
        return $this->_limits;
    }

    public function setLimits(RequestLimit $requestLimit): void
    {
        $this->_limits = $requestLimit;
    }

    public function getStdErr(): string
    {
        return $this->_stderr;
    }

    public function setStdErr(string $path): void
    {
        $this->_stderr = $path;
    }

    public function getStdOut(): string
    {
        return $this->_stdout;
    }

    public function setStdOut(string $path): void
    {
        $this->_stdout = $path;
    }

    public function getWorkingDirectory(): string
    {
        return $this->_working_directory;
    }

    public function setWorkingDirectory(string $path): void
    {
        $this->_working_directory = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * Parse data from array
     *
     * @throws UnitException
     */
    public function parseFromArray(array $data): void
    {
        if (!array_key_exists('type', $data)) {
            throw new UnitException('Parse Exception');
        }

        $this->setType($data['type']);

        if (array_key_exists('working_directory', $data)) {
            $this->setWorkingDirectory($data['working_directory']);
        }

        if (array_key_exists('user', $data)) {
            $this->setUser($data['user']);
        }

        if (array_key_exists('group', $data)) {
            $this->setGroup($data['group']);
        }

        if (array_key_exists('environment', $data)) {
            $this->setEnvironment($data['environment']);
        }

        if (array_key_exists('stderr', $data)) {
            $this->setStdErr($data['stderr']);
        }

        if (array_key_exists('stdout', $data)) {
            $this->setStdOut($data['stdout']);
        }

//        TODO: implement isolation object
//        if (array_key_exists('isolation', $data)) {
//            $this->setIsolation($data['isolation']);
//        }

        if (array_key_exists('processes', $data)) {
            if (is_array($data['processes'])) {
                $this->setProcesses(new ApplicationProcess($data['processes']));
            } else {
                $this->setProcesses($data['processes']);
            }
        }

        if (array_key_exists('limits', $data)) {
            $this->setLimits(new RequestLimit($data['limits']));
        }
    }
}