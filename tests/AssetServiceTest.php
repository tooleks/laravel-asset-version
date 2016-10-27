<?php

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Routing\UrlGenerator;
use Tooleks\LaravelAssetVersion\Services\AssetService;
use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;

/**
 * Class AssetServiceTest
 * @property \Illuminate\Foundation\Application app
 */
class AssetServiceTest extends TestCase
{
    const ASSET_VERSION_NUMBER = '0.0.1';
    const ASSET_PATH = 'css/styles.css';

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        /** @var Application $app */

        $app = app();

        $app->singleton('events', Dispatcher::class);
        $app->singleton('url', UrlGenerator::class);

        $app->make('url')->forceRootUrl($this->baseUrl);

        $app->singleton(AssetServiceContract::class, function () {
            return new AssetService(static::ASSET_VERSION_NUMBER);
        });

        return $app;
    }

    /**
     * Test service class instance.
     */
    public function testConstruct()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $this->assertTrue($assetService instanceof AssetService);
        $this->assertTrue($assetService instanceof AssetServiceContract);
    }

    /**
     * Test asset version.
     */
    public function testAssetVersion()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get(static::ASSET_PATH, false);
        $this->assertTrue(strpos($assetUrl, '?v=' . static::ASSET_VERSION_NUMBER) !== false);

        $secureAssetUrl = $assetService->get(static::ASSET_PATH, true);
        $this->assertTrue(strpos($secureAssetUrl, '?v=' . static::ASSET_VERSION_NUMBER) !== false);
    }

    /**
     * Test secure option passed by parameter on service call.
     */
    public function testSecureOptionFromParameter()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get(static::ASSET_PATH, false);
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'http');

        $secureAssetUrl = $assetService->get(static::ASSET_PATH, true);
        $this->assertTrue(parse_url($secureAssetUrl, PHP_URL_SCHEME) === 'https');
    }

    /**
     * Test secure option passed by configuration file on service init.
     */
    public function testSecureOptionFromConfig()
    {
        /** @var AssetService $assetService */

        $this->app->singleton(AssetServiceContract::class, function () {
            return new AssetService(static::ASSET_VERSION_NUMBER, true);
        });
        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get(static::ASSET_PATH);
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'https');


        $this->app->singleton(AssetServiceContract::class, function () {
            return new AssetService(static::ASSET_VERSION_NUMBER, false);
        });
        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get(static::ASSET_PATH);
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'http');
    }

    /**
     * Test asset path.
     */
    public function testPath()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get(static::ASSET_PATH, false);
        $this->assertTrue(strpos($assetUrl, static::ASSET_PATH) !== false);

        $secureAssetUrl = $assetService->get(static::ASSET_PATH, true);
        $this->assertTrue(strpos($secureAssetUrl, static::ASSET_PATH) !== false);
    }
}
