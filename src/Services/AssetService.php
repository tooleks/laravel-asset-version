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
     * Asset version.
     *
     * @var string
     */
    protected $version;

    /**
     * @inheritdoc
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    /**
     * @inheritdoc
     */
    public function get(string $path, bool $secure = null)
    {
        return asset($this->appendVersion($path), $secure);
    }

    /**
     * Append version parameter to the asset path.
     *
     * @param string $path
     * @return string
     */
    protected function appendVersion(string $path)
    {
        return ($this->version) ? ($path . '?v=' . $this->version) : ($path);
    }
}
