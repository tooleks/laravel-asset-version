<?php

namespace Tooleks\LaravelAssetVersion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Asset.
 * 
 * @see Tooleks\LaravelAssetVersion\Services\AssetService
 * 
 * @package Tooleks\LaravelAssetVersion\Facades
 * @author Oleksandr Tolochko <tooleks@gmail.com>
 */
class Asset extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return \Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract::class;
    }
}
