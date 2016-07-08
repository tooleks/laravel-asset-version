# The Laravel 5 Assets Versioning Package

This package performs versioning of the asset URL resources.

Asset link before versioning:
```
https://website.local/css/main.css
```
Asset link after versioning:
```
https://website.local/css/main.css?v=0.0.1
```

## Requirements

PHP >= 7.0, Laravel >= 5.0.

## Installation

### Package Installation

Execute the following command to get the latest version of the package:

```shell
composer require tooleks/laravel-asset-version
```

### App Configuration

#### Service Registration

To register the service simply add `Tooleks\LaravelAssetVersion\Providers\AssetServiceProvider::class` into your `config/app.php` to the end of the `providers` array:

```php
'providers' => [
    ...
    Tooleks\LaravelAssetVersion\Providers\AssetServiceProvider::class,
],
```

If you prefer to use the service via facade interface add `'Asset' => Tooleks\LaravelAssetVersion\Facades\Asset::class` into your `config/app.php` to the end of the `aliases` array:
```php
'aliases' => [
    ...
    'Asset' => Tooleks\LaravelAssetVersion\Facades\Asset::class,
],
```

#### Publishing File Resources

Run following command in the terminal to publish the package file resources:

```shell
php artisan vendor:publish --provider="Tooleks\LaravelAssetVersion\Providers\AssetServiceProvider" --tag="config"
```

#### Configure Assets Version

Configure assets version number in the `config/assets.php`:

```php
'version' => '0.0.1',
```

## Usage Examples

#### Via Service Object

```php
use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;

$assetUrl = app(AssetServiceContract::class)->get('css/main.css');
// $assetUrl == 'http://website.local/css/main.css?v=0.0.1'

$secureAssetUrl = app(AssetServiceContract::class)->get('css/main.css', true);
// $secureAssetUrl == 'https://website.local/css/main.css?v=0.0.1'
```

#### Via Service Facade Class

```php
use Tooleks\LaravelAssetVersion\Facades\Asset;

$assetUrl = Asset::get('css/main.css');
// $assetUrl == 'http://website.local/css/main.css?v=0.0.1'

$secureAssetUrl = Asset::get('css/main.css', true);
// $secureAssetUrl == 'https://website.local/css/main.css?v=0.0.1'
```

#### In The Layout (Blade Template)
```html
<link href="{{ Asset::get('css/main.css') }}" rel="stylesheet">
```

#### In The Layout (PHP Template)
```html
<link href="<?= Asset::get('css/main.css') ?>" rel="stylesheet">
```
