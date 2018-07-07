<?php declare(strict_types = 1);

/**
 * Test: CacheFactory
 */

use Contributte\Cache\CacheFactory;
use Nette\Caching\Cache;
use Nette\Caching\Storages\DevNullStorage;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test(function (): void {
	$factory = new CacheFactory(new DevNullStorage());

	Assert::type(Cache::class, $factory->create('foo'));
});
