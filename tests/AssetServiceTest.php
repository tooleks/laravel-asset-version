<?php

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Routing\UrlGenerator;
use Tooleks\LaravelAssetVersion\Services\AssetService;
use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;

/**
 * Class AssetServiceTest
 * @property Application app
 */
class AssetServiceTest extends TestCase
{
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

        return $app;
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app->make('url')->forceRootUrl('http://website.domain');

        $this->provideAssetService('0.0.1');
    }

    /**
     * Provide asset service instance.
     *
     * @param string $versionNumber
     * @param null $secure
     * @return AssetServiceContract
     */
    protected function provideAssetService(string $versionNumber, $secure = null)
    {
        $this->app->singleton(AssetServiceContract::class, function () use ($versionNumber, $secure) {
            return new AssetService($versionNumber, $secure);
        });

        return $this->app->make(AssetServiceContract::class);
    }

    /**
     * Test service instance class.
     */
    public function testServiceInstance()
    {
        $assetService = $this->provideAssetService('0.0.1');

        $this->assertTrue($assetService instanceof AssetService);
        $this->assertTrue($assetService instanceof AssetServiceContract);
    }

    /**
     * Test asset version.
     */
    public function testAssetVersion()
    {
        $assetService = $this->provideAssetService('0.0.1');

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(strpos($assetUrl, '?v=0.0.1') !== false);

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(strpos($secureAssetUrl, '?v=0.0.1') !== false);
    }

    /**
     * Test secure option passed on service call.
     */
    public function testSecureOptionOnCall()
    {
        $assetService = $this->provideAssetService('0.0.1');

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'http');

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(parse_url($secureAssetUrl, PHP_URL_SCHEME) === 'https');
    }

    /**
     * Test secure option passed on service init.
     */
    public function testSecureOptionOnInit()
    {
        $assetService = $this->provideAssetService('0.0.1', true);

        $assetUrl = $assetService->get('css/styles.css');
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'https');

        $assetService = $this->provideAssetService('0.0.1', false);

        $assetUrl = $assetService->get('css/styles.css');
        $this->assertTrue(parse_url($assetUrl, PHP_URL_SCHEME) === 'http');
    }

    /**
     * Test asset path.
     */
    public function testPath()
    {
        $assetService = $this->provideAssetService('0.0.1');

        $assetUrl = $assetService->get('css/styles.css', false);
        $this->assertTrue(strpos($assetUrl, 'css/styles.css') !== false);

        $secureAssetUrl = $assetService->get('css/styles.css', true);
        $this->assertTrue(strpos($secureAssetUrl, 'css/styles.css') !== false);
    }
}
