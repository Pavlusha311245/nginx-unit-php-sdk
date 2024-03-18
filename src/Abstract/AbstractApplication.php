<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Config\Application\{ProcessManagement\ApplicationProcess,
    ProcessManagement\ProcessIsolation,
    ProcessManagement\RequestLimit
};
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Contracts\{ApplicationControlInterface, ApplicationInterface, Arrayable, Uploadable};
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements ApplicationInterface, ApplicationControlInterface, Arrayable
 */
abstract class AbstractApplication implements ApplicationInterface, ApplicationControlInterface, Arrayable, Uploadable
{
    use HasListeners;

    /**
     * @var UnitRequest
     */
    private UnitRequest $unitRequest;

    /**
     * Environment variables to be passed to the app
     *
     * @var array
     */
    private array $environment = [];

    /**
     * Group name that runs the app process
     *
     * @var string
     */
    protected string $group = '';

    /**
     * Username that runs the app process
     *
     * @var string
     */
    protected string $user = '';

    /**
     * The app working directory.
     *
     * @var string
     */
    private string $working_directory = '';

    private string $name = '';

    /**
     * The file path to which Unit redirects the application's error stream output in --no-daemon mode.
     *
     * @var string
     */
    private string $stderr = '/dev/null';

    /**
     * The file path to which Unit redirects the output of the application output stream in --no-daemon mode.
     *
     * @var string
     */
    private string $stdout = '/dev/null';

    /**
     * Static number of app processes or object options
     *
     * @var string|ApplicationProcess|null
     */
    private string|null|ApplicationProcess $processes = null;

    /**
     * Control requests limits
     *
     * @var RequestLimit|null
     */
    private ?RequestLimit $limits = null;

    /**
     * You can use namespace and file system isolation for your apps if Unit’s underlying OS supports them
     *
     * @var ProcessIsolation|null
     */
    private ?ProcessIsolation $isolation = null;

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
     * @return AbstractApplication
     */
    public function setUnitRequest(UnitRequest $unitRequest): self
    {
        $this->unitRequest = $unitRequest;

        return $this;
    }

    /**
     * Return application group
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Set application group
     *
     * @param string $name
     * @return AbstractApplication
     */
    public function setGroup(string $name): self
    {
        $this->group = $name;

        return $this;
    }

    /**
     * Return application user
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Set application user
     *
     * @param string $name
     * @return AbstractApplication
     */
    public function setUser(string $name): self
    {
        $this->user = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getEnvironment(): array
    {
        return $this->environment;
    }

    /**
     * Set application environment variables
     *
     * @throws UnitException
     */
    public function setEnvironment(array $environment): self
    {
        foreach ($environment as $value) {
            if (!is_string($value)) {
                throw new UnitException('Parse Exception');
            }
        }

        $this->environment = $environment;

        return $this;
    }

    /**
     * Return ProcessIsolation object
     *
     * @return ProcessIsolation|null
     */
    public function getIsolation(): ?ProcessIsolation
    {
        return $this->isolation;
    }

    /**
     * Set ProcessIsolation object
     *
     * @param ProcessIsolation $isolation
     * @return AbstractApplication
     */
    public function setIsolation(ProcessIsolation $isolation): self
    {
        $this->isolation = $isolation;

        return $this;
    }

    /**
     * Return ProcessApplication object
     *
     * @return ApplicationProcess|int|null
     */
    public function getProcesses(): ApplicationProcess|int|null
    {
        return $this->processes;
    }

    /**
     * Set ProcessApplication object
     *
     * @param ApplicationProcess|int $processes
     * @return AbstractApplication
     */
    public function setProcesses(ApplicationProcess|int $processes): self
    {
        $this->processes = $processes;

        return $this;
    }

    /**
     * Return RequestLimit object
     *
     * @return RequestLimit|null
     */
    public function getLimits(): ?RequestLimit
    {
        return $this->limits;
    }

    /**
     * Set RequestLimit object
     *
     * @param RequestLimit $requestLimit
     * @return AbstractApplication
     */
    public function setLimits(RequestLimit $requestLimit): self
    {
        $this->limits = $requestLimit;

        return $this;
    }

    /**
     * Return stderr stream
     *
     * @return string
     */
    public function getStdErr(): string
    {
        return $this->stderr;
    }

    /**
     * Set stderr stream
     *
     * @param string $path
     * @return AbstractApplication
     */
    public function setStdErr(string $path): self
    {
        $this->stderr = $path;

        return $this;
    }

    /**
     * Return stdout stream
     *
     * @return string
     */
    public function getStdOut(): string
    {
        return $this->stdout;
    }

    /**
     * Set stdout
     *
     * @param string $path
     * @return AbstractApplication
     */
    public function setStdOut(string $path): self
    {
        $this->stdout = $path;

        return $this;
    }

    /**
     * Return working directory
     *
     * @return string
     */
    public function getWorkingDirectory(): string
    {
        return $this->working_directory;
    }

    /**
     * Set working directory
     *
     * @param string $path
     * @return AbstractApplication
     */
    public function setWorkingDirectory(string $path): self
    {
        $this->working_directory = $path;

        return $this;
    }

    /**
     * Return application name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set application name
     *
     * @param string $name
     * @return AbstractApplication
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
            $this->setProcesses(is_array($data['processes'])
                ? new ApplicationProcess($data['processes']) : $data['processes']);
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
            $this->unitRequest->send("/control/applications/{$this->getName()}/restart");
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user' => $this->getUser(),
            'group' => $this->getGroup(),
            'working_directory' => $this->getWorkingDirectory(),
            'environment' => $this->getEnvironment(),
            'stderr' => $this->getStdErr(),
            'stdout' => $this->getStdOut(),
            'isolation' => $this->getIsolation()?->toArray(),
            'processes' => is_int($this->getProcesses()) ? $this->getProcesses() : $this->getProcesses()?->toArray() ?? null,
            'limits' => $this->getLimits()?->toArray(),
        ];
    }

    /**
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode(array_filter(static::toArray(), fn ($item) => !empty($item)), JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param UnitRequest $request
     * @return void
     * @throws UnitException
     */
    public function upload(UnitRequest $request): void
    {
        $request->setMethod('PUT')
            ->send("/config/applications/{$this->getName()}", true, [
                'json' => array_filter($this->toArray(), fn ($item) => !empty($item))
            ]);
    }
}
