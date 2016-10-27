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
            return new AssetService('0.0.1', null);
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
     * Test URL asset version.
     */
    public function testUrlAssetVersion()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(strpos($assetUrl, '?v=0.0.1') !== false);

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(strpos($secureAssetUrl, '?v=0.0.1') !== false);
    }

    /**
     * Test URL schema.
     */
    public function testUrlSchema()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'http');

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(parse_url($secureAssetUrl, PHP_URL_SCHEME) === 'https');
    }

    /**
     * Test URL path.
     */
    public function testUrlPath()
    {
        /** @var AssetService $assetService */

        $assetService = $this->app->make(AssetServiceContract::class);

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(strpos($assetUrl, 'css/styles.css') !== false);

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(strpos($secureAssetUrl, 'css/styles.css') !== false);
    }
}
