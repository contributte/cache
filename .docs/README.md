# Contributte Cache

## Content

- [Setup](#setup)
- [CacheFactory](#cache-factory)
- [Storages](#storages)
- [Debug panel](#debug-panel)

## Setup

```bash
composer require contributte/cache
```

## Cache Factory

Don't waste time by passing `Nette\Caching\IStorage` directly to your classes. Use our tuned `CacheFactory`.

```neon
extensions:
	cache.factory: Contributte\Cache\DI\CacheFactoryExtension
```

By default `Nette\Caching\Cache` is provided when `$cacheFactory->create()` is called. You can change it to your implementation.

```neon
services:
	cache.factory.factory: App\Model\MyCacheFactory
```

## Storages

- MemoryAdapterStorage

    - Optimized for reading of same key multiple times during one application run

```php
use Contributte\Cache\Storages\MemoryAdapterStorage;
use Nette\Caching\Storages\FileStorage;
use Nette\Caching\Storages\SQLiteJournal;

$storage = new MemoryAdapterStorage(
	new FileStorage($path, new SQLiteJournal($path))
);
```

## Debug panel

Show all calls to storage in Tracy panel

```neon
extensions:
	cache.debug: Contributte\Cache\DI\DebugStorageExtension

cache.debug:
	debug: %debugMode%
```

![Debug panel screenshot](_misc/debug-panel-screenshot.png)
