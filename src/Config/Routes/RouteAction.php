<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

class RouteAction
{
    /**
     * Destination for the request, identical to a listener’s pass option.
     *
     * @var string
     */
    private string $_pass;

    /**
     * Socket address of an HTTP server to where the request is proxied.
     *
     * @var string
     */
    private string $_proxy;

    /**
     * HTTP status code with a context-dependent redirect location.
     * Integer (000–999); defines the HTTP response status code to be returned.
     *
     * @var int
     */
    private int $_return;

    /**
     * String URI; used if the return value implies redirection.
     *
     * @var string
     */
    private string $_location;

    /**
     * Lists file paths that are tried until a file is found.
     *
     * @var array|string
     */
    private array|string $_share;

    private string $_index;

    private array $_fallback;

    private array $_types;

    private string $_chroot;

    // TODO: implement getter and setter
    private bool $_follow_symlinks;

    // TODO: implement getter and setter
    private bool $_traverse_mounts;

    private string $_rewrite;

    public function __construct($data = null)
    {
        if (!empty($data)) {
            $this->parseFromArray($data);
        }

//        $this->_share = $data['share'] ?? null;
    }

    /**
     * Receive return key
     *
     * @return mixed
     */
    public function getReturn()
    {
        return $this->_return;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->_pass;
    }

    /**
     * Set return key
     *
     * @param mixed $return
     */
    public function setReturn(int $return): void
    {
        if ($return > 999 && $return < 0) {
            throw new \OutOfRangeException();
        }

        $this->_return = $return;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->_pass = $pass;
    }

    /**
     * @return string
     */
    public function getProxy(): string
    {
        return $this->_proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy(string $proxy): void
    {
        $this->_proxy = $proxy;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->_location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->_location = $location;
    }

    /**
     * @return string
     */
    public function getRewrite(): string
    {
        return $this->_rewrite;
    }

    /**
     * @param string $rewrite
     */
    public function setRewrite(string $rewrite): void
    {
        $this->_rewrite = $rewrite;
    }

    /**
     * @return array|string
     */
    public function getShare(): array|string
    {
        return $this->_share;
    }

    /**
     * @param array|string $share
     */
    public function setShare(array|string $share): void
    {
        $this->_share = $share;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->_index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->_index = $index;
    }

    /**
     * @return string
     */
    public function getChroot(): string
    {
        return $this->_chroot;
    }

    /**
     * @param string $chroot
     */
    public function setChroot(string $chroot): void
    {
        $this->_chroot = $chroot;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->_types;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types): void
    {
        $this->_types = $types;
    }

    /**
     * @return array
     */
    public function getFallback(): array
    {
        return $this->_fallback;
    }

    /**
     * @param array $fallback
     */
    public function setFallback(array $fallback): void
    {
        if (!array_key_exists('pass', $fallback) && !array_key_exists('proxy', $fallback)) {
            throw new UnitException('Parse Exception');
        }

        $this->_fallback = $fallback;
    }

    public function parseFromArray(array $data)
    {
        if (array_key_exists('pass', $data)) {
            $this->setPass($data['pass']);
        }

        if (array_key_exists('proxy', $data)) {
            $this->setProxy($data['proxy']);
        }

        if (array_key_exists('return', $data)) {
            $this->setReturn($data['return']);
        }

        if (array_key_exists('location', $data)) {
            $this->setLocation($data['location']);
        }

        if (array_key_exists('rewrite', $data)) {
            $this->setRewrite($data['rewrite']);
        }

        if (array_key_exists('share', $data)) {
            $this->setShare($data['share']);
        }

        if (array_key_exists('index', $data)) {
            $this->setIndex($data['index']);
        }

        if (array_key_exists('chroot', $data)) {
            $this->setChroot($data['chroot']);
        }

        if (array_key_exists('types', $data)) {
            $this->setTypes($data['types']);
        }

        if (array_key_exists('fallback', $data)) {
            $this->setFallback($data['fallback']);
        }
    }
}
