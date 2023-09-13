<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Config\Application\{ProcessManagement\ApplicationProcess,
    ProcessManagement\ProcessIsolation,
    ProcessManagement\RequestLimit
};
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Contracts\{ApplicationControlInterface, ApplicationInterface, Arrayable};
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements ApplicationInterface, ApplicationControlInterface, Arrayable
 */
abstract class ApplicationAbstract implements ApplicationInterface, ApplicationControlInterface, Arrayable
{
    use HasListeners;

    /**
     * Application type
     *
     * @var string
     */
    protected string $_type;

    /**
     * @var UnitRequest
     */
    private UnitRequest $_unitRequest;

    /**
     * Environment variables to be passed to the app
     *
     * @var array
     */
    private array $_environment = [];

    /**
     * Group name that runs the app process
     *
     * @var string
     */
    protected string $_group = '';

    /**
     * Username that runs the app process
     *
     * @var string
     */
    protected string $_user = '';

    /**
     * The app working directory.
     *
     * @var string
     */
    private string $_working_directory = '';

    private string $_name = '';

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
     * @var string|ApplicationProcess|null
     */
    private string|null|ApplicationProcess $_processes = null;

    /**
     * Control requests limits
     *
     * @var RequestLimit|null
     */
    private ?RequestLimit $_limits = null;

    /**
     * You can use namespace and file system isolation for your apps if Unit’s underlying OS supports them
     *
     * @var ProcessIsolation|null
     */
    private ?ProcessIsolation $_isolation = null;

    /**
     * @throws UnitException
     */
    public function __construct($data = null)
    {
        if (!empty($data)) {
            $this->parseFromArray($data);
        }
    }

    /**
     * @param UnitRequest $unitRequest
     */
    public function setUnitRequest(UnitRequest $unitRequest): void
    {
        $this->_unitRequest = $unitRequest;
    }

    public function getType(): string
    {
        return $this->_type;
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

    /**
     * @throws UnitException
     */
    public function setEnvironment(array $environment): void
    {
        foreach ($environment as $value) {
            if (!is_string($value)) {
                throw new UnitException('Parse Exception');
            }
        }

        $this->_environment = $environment;
    }

    public function getIsolation(): ?ProcessIsolation
    {
        return $this->_isolation;
    }

    public function setIsolation(ProcessIsolation $isolation): void
    {
        $this->_isolation = $isolation;
    }

    public function getProcesses(): ApplicationProcess|int|null
    {
        return $this->_processes;
    }

    public function setProcesses(ApplicationProcess|int $processes): void
    {
        $this->_processes = $processes;
    }

    public function getLimits(): ?RequestLimit
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
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function parseFromArray(array $data): void
    {
        if (!array_key_exists('type', $data)) {
            throw new UnitException('Parse Exception');
        }

        $this->_type = $data['type'];

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

        if (array_key_exists('isolation', $data)) {
            $this->setIsolation(new ProcessIsolation($data['isolation']));
        }

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

    /**
     * @inheritDoc
     */
    public function restartApplication(): bool
    {
        try {
            $this->_unitRequest->send("/control/applications/{$this->getName()}/restart");
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'user' => $this->getUser(),
            'group' => $this->getGroup(),
            'environment' => $this->getEnvironment(),
            'stderr' => $this->getStdErr(),
            'stdout' => $this->getStdOut(),
            'isolation' => $this->getIsolation()?->toArray(),
            'processes' => is_int($this->getProcesses()) ? $this->getProcesses() : $this->getProcesses()?->toArray() ?? null,
            'limits' => $this->getLimits()?->toArray(),
        ];
    }

    public function toJson(): string|false
    {
        return json_encode(array_filter(static::toArray(), fn ($item) => !empty($item)));
    }
}
