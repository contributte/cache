<?php

/**
 * Test: DI\CacheFactoryExtension
 */

use Contributte\Cache\CacheFactory;
use Contributte\Cache\DI\CacheFactoryExtension;
use Contributte\Cache\ICacheFactory;
use Nette\Bridges\CacheDI\CacheExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

test(function () {
	$loader = new ContainerLoader(TEMP_DIR, TRUE);
	$class = $loader->load(function (Compiler $compiler) {
		$compiler->addExtension('cacheFactory', new CacheFactoryExtension());
		$compiler->addExtension('cache', new CacheExtension(TEMP_DIR));
	}, 1);

	/** @var Container $container */
	$container = new $class;

	Assert::type(CacheFactory::class, $container->getByType(ICacheFactory::class));
});
