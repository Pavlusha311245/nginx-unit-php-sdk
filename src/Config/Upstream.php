<?php

namespace UnitPhpSdk\Config;

use OutOfRangeException;
use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Config\Upstream\Server;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Contracts\UpstreamInterface;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\CanUpload;
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements UpstreamInterface
 */
class Upstream implements UpstreamInterface, Uploadable, Arrayable
{
    use HasListeners;
    use CanUpload;

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

        $this->setApiEndpoint(ApiPathEnum::UPSTREAM->getPath($this->getName()));
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
}
