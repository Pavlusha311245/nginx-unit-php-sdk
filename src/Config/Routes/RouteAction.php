<?php

namespace UnitPhpSdk\Config\Routes;

use OutOfRangeException;
use UnitPhpSdk\Exceptions\UnitException;

class RouteAction
{
    /**
     * Possible action types pass, proxy, return, share
     *
     * @var string The type of action to be performed.
     */
    private string $actionType = '';

    /**
     * Destination for the request, identical to a listener’s pass option.
     *
     * @var string
     */
    private string $pass = '';

    /**
     * Socket address of an HTTP server to where the request is proxied.
     *
     * @var string
     */
    private string $proxy = '';

    /**
     * HTTP status code with a context-dependent redirect location.
     * Integer (000–999); defines the HTTP response status code to be returned.
     *
     * @var int|null
     */
    private ?int $return = null;

    /**
     * String URI; used if the return value implies redirection.
     *
     * @var string
     */
    private string $location = '';

    /**
     * Lists file paths that are tried until a file is found.
     *
     * @var array|string
     */
    private array|string $share = '';

    private string $index = '';

    /**
     * @var array
     */
    private array $fallback = [];

    /**
     * @var array
     */
    private array $types = [];

    /**
     * @var string
     */
    private string $chroot = '';

    /**
     * @var bool
     */
    private bool $follow_symlinks = true;

    /**
     * @var bool
     */
    private bool $traverse_mounts = true;

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
     * @return int|null
     */
    public function getReturn(): ?int
    {
        return $this->return;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * Set return key
     *
     * @param mixed $return
     */
    public function setReturn(int $return): void
    {
        if ($return > 999 || $return < 0) {
            throw new OutOfRangeException();
        }

        $this->return = $return;

        $this->setActionType('return');
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;

        $this->setActionType('pass');
    }

    /**
     * @return string
     */
    public function getProxy(): string
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy(string $proxy): void
    {
        $this->proxy = $proxy;

        $this->setActionType('proxy');
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
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
     * @return array|string
     */
    public function getShare(): array|string
    {
        return $this->share;
    }

    /**
     * @param array|string $share
     */
    public function setShare(array|string $share): void
    {
        $this->share = $share;

        $this->setActionType('share');
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getChroot(): string
    {
        return $this->chroot;
    }

    /**
     * @param string $chroot
     */
    public function setChroot(string $chroot): void
    {
        $this->chroot = $chroot;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    /**
     * @return array
     */
    public function getFallback(): array
    {
        return $this->fallback;
    }

    /**
     * @param array $fallback
     * @throws UnitException
     */
    public function setFallback(array $fallback): void
    {
        if (!array_key_exists('pass', $fallback) && !array_key_exists('proxy', $fallback)) {
            throw new UnitException('Parse Exception');
        }

        $this->fallback = $fallback;
    }

    /**
     * @param bool $follow_symlinks
     */
    public function setFollowSymlinks(bool $follow_symlinks): void
    {
        $this->follow_symlinks = $follow_symlinks;
    }

    /**
     * @param bool $traverse_mounts
     */
    public function setTraverseMounts(bool $traverse_mounts): void
    {
        $this->traverse_mounts = $traverse_mounts;
    }

    /**
     * @return bool
     */
    public function isFollowSymlinks(): bool
    {
        return $this->follow_symlinks;
    }

    /**
     * @return bool
     */
    public function isTraverseMounts(): bool
    {
        return $this->traverse_mounts;
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
     * @return string
     */
    public function getActionType(): string
    {
        return $this->actionType;
    }

    /**
     * @param string $actionType
     */
    public function setActionType(string $actionType): void
    {
        $this->actionType = $actionType;
    }

    /**
     * @throws UnitException
     */
    public function parseFromArray(array $data): void
    {
        // Action types

        if (array_key_exists('pass', $data)) {
            $this->setPass($data['pass']);
            $this->setActionType('pass');
        }

        if (array_key_exists('proxy', $data)) {
            $this->setProxy($data['proxy']);
            $this->setActionType('proxy');
        }

        if (array_key_exists('return', $data)) {
            $this->setReturn($data['return']);
            $this->setActionType('return');

            // Data for the return action type

            if (array_key_exists('location', $data)) {
                $this->setLocation($data['location']);
            }
        }

        if (array_key_exists('share', $data)) {
            $this->setShare($data['share']);
            $this->setActionType('share');

            // Data for the share action type

            if (array_key_exists('index', $data)) {
                $this->setIndex($data['index']);
            }

            if (array_key_exists('fallback', $data)) {
                $this->setFallback($data['fallback']);
            }

            if (array_key_exists('chroot', $data)) {
                $this->setChroot($data['chroot']);
            }

            if (array_key_exists('types', $data)) {
                $this->setTypes($data['types']);
            }

            if (array_key_exists('follow_symlinks', $data)) {
                $this->setFollowSymlinks($data['follow_symlinks']);
            }

            if (array_key_exists('traverse_mounts', $data)) {
                $this->setTraverseMounts($data['traverse_mounts']);
            }
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
    public function toArray(): array
    {
        return [
            'pass' => $this->getPass(),
            'response_headers' => $this->getResponseHeaders(),
            'proxy' => $this->getProxy(),
            'return' => $this->getReturn(),
            'location' => $this->getLocation(),
            'rewrite' => $this->getRewrite(),
            'share' => $this->getShare(),
            'index' => $this->getIndex(),
            'chroot' => $this->getChroot(),
            'types' => $this->getTypes(),
            'fallback' => $this->getFallback(),
            'follow_symlinks' => $this->isFollowSymlinks(),
            'traverse_mounts' => $this->isTraverseMounts(),
        ];
    }
}
