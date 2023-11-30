<?php

namespace UnitPhpSdk\Config\Routes;

use UnitPhpSdk\Contracts\Arrayable;

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
     */
    public function setMatch(?RouteMatch $match): void
    {
        $this->match = $match;
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
     */
    public function setAction(?RouteAction $action): void
    {
        $this->action = $action;
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
            'match' => $this->getMatch()?->toArray(),
            'action' => $this->getAction()->toArray(),
        ];
    }
}
