<?php

namespace UnitPhpSdk\Config\Routes;

use OutOfRangeException;
use UnitPhpSdk\Config\Routes\ActionType\PassAction;
use UnitPhpSdk\Config\Routes\ActionType\ProxyAction;
use UnitPhpSdk\Config\Routes\ActionType\ReturnAction;
use UnitPhpSdk\Config\Routes\ActionType\ShareAction;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Enums\RouteActionTypeEnum;
use UnitPhpSdk\Exceptions\UnitException;

class RouteAction implements Arrayable
{
    /**
     * Possible action types pass, proxy, return, share
     *
     * @var RouteActionTypeEnum|null The type of action to be performed.
     */
    private RouteActionTypeEnum|null $actionType = null;

    /**
     * Destination for the request, identical to a listener’s pass option.
     *
     * @var PassAction|null
     */
    private ?PassAction $pass = null;

    /**
     * Socket address of an HTTP server to where the request is proxied.
     *
     * @var ProxyAction|null
     */
    private ?ProxyAction $proxy = null;

    /**
     * @var ReturnAction|null
     */
    private ?ReturnAction $return = null;

    /**
     * Share a directory or a file.
     *
     * @var ShareAction|null
     */
    private ?ShareAction $share = null;

    /**
     * Updates the header fields of the upcoming response.
     *
     * @var array
     */
    private array $response_headers = [];

    /**
     * Updated the request URI, preserving the query string.
     *
     * @var string|null
     */
    private ?string $rewrite = null;

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
     * Receive return key
     *
     * @return ReturnAction|null
     */
    public function getReturn(): ?ReturnAction
    {
        return $this->return;
    }

    /**
     * @return PassAction|null
     */
    public function getPass(): ?PassAction
    {
        return $this->pass;
    }

    /**
     * Set return key
     *
     * @param mixed $return
     */
    public function setReturn(ReturnAction $return): void
    {
        $this->return = $return;

        $this->setActionType(RouteActionTypeEnum::RETURN);
    }

    /**
     * @param PassAction $pass
     */
    public function setPass(PassAction $pass): void
    {
        $this->pass = $pass;

        $this->setActionType(RouteActionTypeEnum::PASS);
    }

    /**
     * @return ProxyAction
     */
    public function getProxy(): ?ProxyAction
    {
        return $this->proxy;
    }

    /**
     * @param ProxyAction $proxy
     */
    public function setProxy(ProxyAction $proxy): void
    {
        $this->proxy = $proxy;

        $this->setActionType(RouteActionTypeEnum::PROXY);
    }

    /**
     * @return string|null
     */
    public function getRewrite(): ?string
    {
        return $this->rewrite;
    }

    /**
     * @param string|null $rewrite
     */
    public function setRewrite(?string $rewrite): void
    {
        $this->rewrite = $rewrite;
    }

    /**
     * @return ShareAction|null
     */
    public function getShare(): ?ShareAction
    {
        return $this->share;
    }

    /**
     * @param ShareAction $share
     */
    public function setShare(ShareAction $share): void
    {
        $this->share = $share;

        $this->setActionType(RouteActionTypeEnum::SHARE);
    }

    /**
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->response_headers;
    }

    /**
     * @param array $response_headers
     */
    public function setResponseHeaders(array $response_headers): void
    {
        $this->response_headers = $response_headers;
    }

    /**
     * Return true if action is static
     *
     * @return bool
     */
    public function isStatic(): bool
    {
        return !empty($this->getShare());
    }

    /**
     * @return RouteActionTypeEnum
     */
    public function getActionType(): RouteActionTypeEnum
    {
        return $this->actionType;
    }

    /**
     * @param RouteActionTypeEnum $actionType
     */
    public function setActionType(RouteActionTypeEnum $actionType): void
    {
        $this->actionType = $actionType;
    }

    /**
     * @param array $data
     */
    public function parseFromArray(array $data): void
    {
        // Action types
        if (array_key_exists('pass', $data)) {
            $this->setPass(new PassAction($data['pass']));
        }

        if (array_key_exists('proxy', $data)) {
            $this->setProxy(new ProxyAction($data['proxy']));
        }

        if (array_key_exists('return', $data)) {
            $returnAction = array_key_exists('location', $data) ?
                new ReturnAction($data['return'], $data['location']) :
                new ReturnAction($data['return']);

            $this->setReturn($returnAction);
        }

        if (array_key_exists('share', $data)) {
            $this->setShare(new ShareAction($data['share'], $data));
        }

        // Additional options for any action type

        if (array_key_exists('rewrite', $data)) {
            $this->setRewrite($data['rewrite']);
        }

        if (array_key_exists('response_headers', $data) && is_array($data['response_headers'])) {
            $this->setResponseHeaders($data['response_headers']);
        }
    }

    /**
     * @return array
     */
    #[\Override] public function toArray(): array
    {
        $data = [];

        if (!empty($this->getResponseHeaders())) {
            $data['response_headers'] = $this->getResponseHeaders();
        }

        if (!empty($this->getRewrite())) {
            $data['rewrite'] = $this->getRewrite();
        }

        if ($this->getPass() !== null) {
            return array_merge($data, $this->getPass()->toArray());
        }

        if ($this->getReturn() !== null) {
            return array_merge($data, $this->getReturn()->toArray());
        }

        if ($this->getShare() !== null) {
            return array_merge($data, $this->getShare()->toArray());
        }

        if ($this->getProxy() !== null) {
            return array_merge($data, $this->getProxy()->toArray());
        }

        return $data;
    }
}
