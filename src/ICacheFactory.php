<?php
namespace Contributte\Cache;

use Nette\Caching\Cache;

interface ICacheFactory
{

	/**
	 * @param string $namespace
	 * @return Cache
	 */
	public function create($namespace);

}
