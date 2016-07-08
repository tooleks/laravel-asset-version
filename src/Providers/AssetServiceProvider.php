<?php

namespace Tooleks\LaravelAssetVersion\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AssetServiceProvider.
 *
 * @package Tooleks\LaravelAssetVersion\Providers
 * @author Oleksandr Tolochko <tooleks@gmail.com>
 */
class AssetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/assets.php' => config_path('assets.php')], 'config');

        $this->app->singleton(\Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract::class, function () {
            return new \Tooleks\LaravelAssetVersion\Services\AssetService(config('assets.version'));
        });
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
    }
}
