<?php declare(strict_types = 1);

namespace Contributte\Cache\DI;

use Contributte\Cache\Storages\LoggableStorage;
use Contributte\Cache\Tracy\StoragePanel;
use Nette\Caching\IStorage;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;
use Tracy\Bar;

/**
 * @property-read stdClass $config
 */
final class DebugStorageExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(false),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		if (!$config->debug) {
			return;
		}

		$builder->addDefinition($this->prefix('tracy.panel'))
			->setFactory(StoragePanel::class)
			->setType(StoragePanel::class)
			->setAutowired(false);
	}

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		if (!$config->debug) {
			return;
		}

		$originalStorage = $builder->getDefinitionByType(IStorage::class)
			->setAutowired(false);

		$builder->addDefinition($this->prefix('loggable'))
			->setFactory(LoggableStorage::class, [$originalStorage]);

		$tracyBarDefinition = $builder->getDefinitionByType(Bar::class);
		assert($tracyBarDefinition instanceof ServiceDefinition);
		$tracyBarDefinition->addSetup('$service->addPanel(?)', ['@' . $this->prefix('tracy.panel')]);
	}

}
