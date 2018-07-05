<?php declare(strict_types = 1);

namespace Contributte\Cache\DI;

use Contributte\Cache\CacheFactory;
use Nette\DI\CompilerExtension;

class CacheFactoryExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('factory'))
			->setFactory(CacheFactory::class);
	}

}
