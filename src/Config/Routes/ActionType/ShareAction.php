<?php

namespace UnitPhpSdk\Config\Routes\ActionType;

use Override;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\UnitException;

class ShareAction implements Arrayable
{
    /**
     * Filename; tried if share is a directory. When no file is found, fallback is used if set.
     *
     * @var string
     */
    private string $index = 'index.html';

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

    public function __construct(
        private string $share,
        $data = []
    ) {
        $this->parseData($data);
    }

    /**
     * @return string
     */
    public function getShare(): string
    {
        return $this->share;
    }

    /**
     * @param string $share
     */
    public function setShare(string $share): void
    {
        $this->share = $share;
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
     * TODO: Create fallback
     *
     * @param array $fallback
     * @throws UnitException
     */
    public function setFallback(array $fallback): void
    {
        // TODO: fix it
        //        if (!array_key_exists('pass', $fallback) && !array_key_exists('proxy', $fallback)) {
        //            throw new UnitException('Parse Exception');
        //        }

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
     * @throws UnitException
     */
    private function parseData(array $data): void
    {
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

    #[Override] public function toArray(): array
    {
        return [
            'share' => $this->getShare(),
            'index' => $this->getIndex(),
            'fallback' => $this->getFallback(),
            'chroot' => $this->getChroot(),
            'types' => $this->getTypes(),
            // TODO: fix broken functionality
//            'follow_symlinks' => $this->isFollowSymlinks(),
//            'traverse_mounts' => $this->isTraverseMounts(),
        ];
    }
}
