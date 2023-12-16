<?php

namespace UnitPhpSdk\Config\Routes;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\UnitException;

/**
 * @implements Arrayable
 */
class RouteBlock implements Arrayable
{
    /**
     * @var RouteAction|null
     */
    private ?RouteAction $action = null;

    /**
     * @var RouteMatch|null
     */
    private ?RouteMatch $match = null;

    /**
     * @throws UnitException
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->action = new RouteAction($data['action']);
            if (isset($data['match'])) {
                $this->match = new RouteMatch($data['match']);
            }
        }
    }

    /**
     * @param RouteMatch|null $match
     * @return RouteBlock
     */
    public function setMatch(?RouteMatch $match): self
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get match
     *
     * @return RouteMatch|null
     */
    public function getMatch(): RouteMatch|null
    {
        return $this->match;
    }

    /**
     * @param RouteAction|null $action
     * @return RouteBlock
     */
    public function setAction(?RouteAction $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return mixed
     */
    public function getAction(): RouteAction
    {
        return $this->action;
    }

    public function toArray(): array
    {
        return [
            'action' => $this->getAction()->toArray(),
            'match' => $this->getMatch()?->toArray(),
        ];
    }
}
