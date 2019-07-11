<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use Contributte\Cache\DI\DebugStorageExtension;
use Contributte\Cache\Storages\LoggableStorage;
use Contributte\Cache\Tracy\StoragePanel;
use Nette\Bridges\CacheDI\CacheExtension;
use Nette\Caching\IStorage;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;
use Tester\TestCase;
use Tracy\Bridges\Nette\TracyExtension;

require_once __DIR__ . '/../../bootstrap.php';

class DebugStorageExtensionTest extends TestCase
{

	public function testOk(): void
	{
		$loader = new ContainerLoader(TEMP_DIR, true);
		$class = $loader->load(function (Compiler $compiler): void {
			$compiler->addExtension('tracy', new TracyExtension());
			$compiler->addExtension('cache', new CacheExtension(TEMP_DIR));
			$compiler->addExtension('cacheDebug', new DebugStorageExtension());
			$compiler->loadConfig(__DIR__ . '/debugStorage.neon');
		}, 1);

		/** @var Container $container */
		$container = new $class();

		Assert::true($container->getByType(IStorage::class) instanceof LoggableStorage);
		Assert::true($container->getService('cacheDebug.tracy.panel') instanceof StoragePanel);
	}

}

(new DebugStorageExtensionTest())->run();
