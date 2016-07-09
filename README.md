# The Laravel 5 Assets Versioning Package

This package performs versioning of the asset URL resources.

Asset link before versioning:
```
https://website.domain/path/to/asset.css
```
Asset link after versioning:
```
https://website.domain/path/to/asset.css?v=0.0.1
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
...
'version' => '0.0.1',
...
```

## Basic Usage Examples

#### Via Service Object

```php
use Tooleks\LaravelAssetVersion\Contracts\AssetServiceContract;

$assetUrl = app(AssetServiceContract::class)->get('path/to/asset.css'); // 'http://website.domain/path/to/asset.css?v=0.0.1'

$secureAssetUrl = app(AssetServiceContract::class)->get('path/to/asset.css', true); // 'https://website.domain/path/to/asset.css?v=0.0.1'
```

#### Via Service Facade Class

```php
use Tooleks\LaravelAssetVersion\Facades\Asset;

$assetUrl = Asset::get('path/to/asset.css'); // 'http://website.domain/path/to/asset.css?v=0.0.1'

$secureAssetUrl = Asset::get('path/to/asset.css', true); // 'https://website.domain/path/to/asset.css?v=0.0.1'
```

#### In The Layout (Blade Template)
```html
<link href="{{ Asset::get('path/to/asset.css') }}" rel="stylesheet" type="text/css">
```

#### In The Layout (PHP Template)
```html
<link href="<?= Asset::get('path/to/asset.css') ?>" rel="stylesheet" type="text/css">
```
