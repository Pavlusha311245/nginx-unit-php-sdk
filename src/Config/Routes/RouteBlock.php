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
    private ?RouteAction $_action = null;

    /**
     * @var RouteMatch|null
     */
    private ?RouteMatch $_match = null;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->_action = new RouteAction($data['action']);
            if (isset($data['match'])) {
                $this->_match = new RouteMatch($data['match']);
            }
        }
    }

    /**
     * @param RouteMatch|null $match
     */
    public function setMatch(?RouteMatch $match): void
    {
        $this->_match = $match;
    }

    /**
     * Get match
     *
     * @return RouteMatch|null
     */
    public function getMatch(): RouteMatch|null
    {
        return $this->_match;
    }

    /**
     * @param RouteAction|null $action
     */
    public function setAction(?RouteAction $action): void
    {
        $this->_action = $action;
    }

    /**
     * Get action
     *
     * @return mixed
     */
    public function getAction(): RouteAction
    {
        return $this->_action;
    }

    public function toArray(): array
    {
        return [
            'match' => $this->getMatch()?->toArray(),
            'action' => $this->getAction()->toArray(),
        ];
    }
}
