<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Config\Application\{ProcessManagement\ApplicationProcess,
    ProcessManagement\ProcessIsolation,
    ProcessManagement\RequestLimit
};
use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Contracts\{ApplicationInterface, Arrayable, Uploadable};
use UnitPhpSdk\Traits\CanUpload;
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements ApplicationInterface
 * @implements Arrayable
 * @implements Uploadable
 */
abstract class AbstractApplication implements ApplicationInterface, Arrayable, Uploadable
{
    use HasListeners;
    use CanUpload;

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
     * @param string $name
     * @param array|null $data
     */
    public function __construct(string $name, ?array $data = [])
    {
        $this->setName($name);

        if (!empty($data)) {
            $this->parseFromArray($data);
        }

        $this->setApiEndpoint(EndpointBuilder::create(ApiPathEnum::APPLICATIONS->value)->get() . $this->getName());
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
     * @throws UnitException
     */
    public function setIsolation(ProcessIsolation $isolation): self
    {
        $this->isolation = is_array($isolation) ? new ProcessIsolation($isolation) : $isolation;

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
     * @param ApplicationProcess|int|array $processes
     * @return AbstractApplication
     */
    public function setProcesses(ApplicationProcess|int|array $processes): self
    {
        $this->processes = is_array($processes) ? new ApplicationProcess($processes) : $processes;

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
     * @param RequestLimit|array $requestLimit
     * @return AbstractApplication
     */
    public function setLimits(RequestLimit|array $requestLimit): self
    {
        $this->limits = is_array($requestLimit) ? new RequestLimit($requestLimit) : $requestLimit;

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
     */
    public function parseFromArray(array $data): void
    {
        $data = array_filter($data, fn ($item) => !empty($item), ARRAY_FILTER_USE_BOTH);

        $attributes = ['working_directory', 'user', 'group', 'environment', 'stderr', 'stdout', 'isolation', 'processes', 'limits',];

        foreach ($attributes as $attribute) {
            $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
            $method = "set" . $camelCase;

            $this->setDataAttributeIfExists($data, $attribute, $method);
        }
    }

    /**
     * If the given key exists in the data array, call the corresponding setter method.
     *
     * @param array $data
     * @param string $key
     * @param string $method
     */
    protected function setDataAttributeIfExists(array $data, string $key, string $method): void
    {
        if (array_key_exists($key, $data)) {
            $this->$method($data[$key]);
        }
    }

    /**
     * @return array
     */
    #[\Override] public function toArray(): array
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
}
