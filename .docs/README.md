# Cache / Caching

## Content

- [CacheFactoryExtension - provides simple CacheFactory](#cache-factory)
- [Storages](#storages)

## Cache Factory

This simple extesions is very useful. Don't waste time by passing `Nette\Caching\IStorage` directly to 
your classes. Use our tuned `CacheFactory`. 

```yaml
extensions:
    cache: Contributte\Cache\DI\CacheFactoryExtension
```

By default `Nette\Caching\Cache` is provided when `$cacheFactory->create()` is called. You can change it to your implementation.

```yaml
services:
    cache.factory: App\Model\MyCacheFactory
```

### Storages

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
