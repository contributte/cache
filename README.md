# Cache

:sparkles: Extra contrib to [nette/cache](https://github.com/nette/cache).

-----

[![Build Status](https://img.shields.io/travis/contributte/cache.svg?style=flat-square)](https://travis-ci.org/contributte/cache)
[![Code coverage](https://img.shields.io/coveralls/contributte/cache.svg?style=flat-square)](https://coveralls.io/r/contributte/cache)
[![Downloads this Month](https://img.shields.io/packagist/dm/contributte/cache.svg?style=flat-square)](https://packagist.org/packages/contributte/cache)
[![Downloads total](https://img.shields.io/packagist/dt/contributte/cache.svg?style=flat-square)](https://packagist.org/packages/contributte/cache)
[![Latest stable](https://img.shields.io/packagist/v/contributte/cache.svg?style=flat-square)](https://packagist.org/packages/contributte/cache)
[![HHVM Status](https://img.shields.io/hhvm/contributte/cache.svg?style=flat-square)](http://hhvm.h4cc.de/package/contributte/cache)

## Discussion / Help

[![Join the chat](https://img.shields.io/gitter/room/contributte/contributte.svg?style=flat-square)](https://gitter.im/contributte/contributte?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Install

```
composer require contributte/cache
```

## Usage

### `CacheFactory`

```yaml
extensions:
    cacheFactory: Contributte\Cache\DI\CacheFactoryExtension
```

You can override it by your implementation.

```yaml
services:
    cacheFactory.factory: My\CacheFactory
```

-----

Thank you for testing, reporting and contributing.
