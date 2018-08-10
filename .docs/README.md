# Cache / Caching

## Content

- [CacheFactoryExtension - provides simple CacheFactory](#cache-factory)
- [Storages](#storages)

## Cache Factory

This simple extesions is at all very useful. Don't wase of time of passing directly `Nette\Caching\IStorage` to 
your classes. You our tuned `CacheFactory`. 

```yaml
extensions:
    cache: Contributte\Cache\DI\CacheFactoryExtension
```

By default is provided `Nette\Caching\Cache` when `$cacheFactory->create()` is called. You can change it to your implementation.

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
