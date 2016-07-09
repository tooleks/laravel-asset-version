<?php

namespace Tooleks\LaravelAssetVersion\Providers;

use Illuminate\Support\ServiceProvider;
use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;
use Tooleks\LaravelAssetVersion\Services\AssetService;

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
        $this->publishes([
            __DIR__ . '/../../config/assets.php' => config_path('assets.php')
        ], 'config');

        $this->app->singleton(AssetServiceContract::class, function () {
            return new AssetService(config('assets.version'), config('assets.secure'));
        });
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
    }
}
