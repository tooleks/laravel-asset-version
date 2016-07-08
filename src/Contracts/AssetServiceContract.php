<?php

namespace Tooleks\LaravelAssetVersion\Contracts;

/**
 * Interface AssetServiceContract.
 * 
 * @package Tooleks\LaravelAssetVersion\Contracts
 * @author Oleksandr Tolochko <tooleks@gmail.com>
 */
interface AssetServiceContract
{
    /**
     * AssetServiceContract constructor.
     *
     * @param string $version
     */
    public function __construct(string $version);

    /**
     * Generate an asset path with version parameter for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    public function get(string $path, bool $secure = null);
}
