<?php

namespace UnitPhpSdk\Config;

use OutOfRangeException;
use UnitPhpSdk\Config\Upstream\Server;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Contracts\UpstreamInterface;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements UpstreamInterface
 */
class Upstream implements UpstreamInterface, Uploadable, Arrayable
{
    use HasListeners;

    /**
     * Array of servers
     *
     * @var array
     */
    private array $servers = [];

    public function __construct(
        private readonly string $name,
        array                   $data = []
    ) {
        if (!empty($data)) {
            foreach ($data as $server) {
                $this->servers[] = $server instanceof Server ? $server : new Server($server);
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $pass
     * @param int $weight
     * @return void
     * @throws UnitException
     */
    public function setServer(string $pass, int $weight = 1): void
    {
        if ($weight < 0 || $weight > 1000000) {
            throw new OutOfRangeException('Weight should be between 0 and 1000000');
        }

        $parts = parse_url($pass);

        if (!filter_var($parts['host'], FILTER_VALIDATE_IP)) {
            throw new UnitException($parts['host'] . " isn't a valid IP address");
        }

        if ((int)$parts['port'] < 1 || (int)$parts['port'] > 65535) {
            throw new UnitException($parts['port'] . " isn't a valid port number (allowed range is 1 to 65535)");
        }

        $this->servers[$parts['host']] = [
            'weight' => $weight
        ];
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        $serverArr = [];
        foreach ($this->servers as $server) {
            $serverArr += $server->toArray();
        }

        return $serverArr;
    }

    /**
     * @return array[]
     */
    #[\Override] public function toArray(): array
    {

        return [
            'servers' => $this->getServers()
        ];
    }

    /**
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode($this->toArray());
    }

    /**
     * @param UnitRequest $request
     * @return bool
     */
    #[\Override] public function upload(UnitRequest $request)
    {
        try {
            $request
                ->setMethod(HttpMethodsEnum::PUT->value)
                ->send($this->getApiEndpoint(), requestOptions: [
                    'json' => $this->toArray()
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Removes the upstream configuration for this unit.
     *
     * @param UnitRequest $request The unit request object.
     *
     * @return bool Returns true if the upstream configuration was successfully removed,
     *              otherwise false if an exception occurred.
     */
    #[\Override] public function remove(UnitRequest $request)
    {
        try {
            $request->setMethod(HttpMethodsEnum::DELETE->value)->send($this->getApiEndpoint());
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    public function getApiEndpoint(): string
    {
        return "/config/upstreams/{$this->getName()}";
    }
}
