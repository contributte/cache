<?php

namespace Contributte\Cache\DI;

use Contributte\Cache\CacheFactory;
use Nette\DI\CompilerExtension;

final class CacheExtensions extends CompilerExtension
{

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('factory'))
			->setFactory(CacheFactory::class);
	}

}
