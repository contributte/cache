<?php

namespace Contributte\Cache;

use Nette\Caching\Cache;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
interface ICacheFactory
{

	/**
	 * @param string $namespace
	 * @return Cache
	 */
	public function create($namespace);

}
