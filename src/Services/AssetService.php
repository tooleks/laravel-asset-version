<?php

namespace Tooleks\LaravelAssetVersion\Services;

use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;

/**
 * Class AssetService.
 *
 * @package Tooleks\LaravelAssetVersion\Services
 * @author Oleksandr Tolochko <tooleks@gmail.com>
 */
class AssetService implements AssetServiceContract
{
    /**
     * Asset version number.
     *
     * @var string
     */
    protected $version;

    /**
     * Asset secure option.
     *
     * @var bool|null
     */
    protected $secure;

    /**
     * @inheritdoc
     */
    public function __construct(string $version, $secure = null)
    {
        $this->version = $version;
        $this->secure = $secure;
    }

    /**
     * @inheritdoc
     */
    public function getVersion() : string
    {
        return $this->version;
    }

    /**
     * @inheritdoc
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @inheritdoc
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @inheritdoc
     */
    public function setSecure(bool $secure)
    {
        $this->secure = $secure;
    }

    /**
     * @inheritdoc
     */
    public function get(string $path, bool $secure = null) : string
    {
        if ($secure === null) {
            $secure = $this->getSecure();
        }

        return asset($this->appendVersionToPath($path), $secure);
    }

    /**
     * Append version parameter to the asset path.
     *
     * @param string $path
     * @return string
     */
    protected function appendVersionToPath(string $path) : string
    {
        return ($this->version) ? ($path . '?v=' . $this->version) : ($path);
    }
}
