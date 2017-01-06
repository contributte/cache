# Cache / Caching

## Content

- [CacheFactoryExtension - provides simple CacheFactory](#cache-factory)

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
