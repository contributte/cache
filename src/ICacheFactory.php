<?php declare(strict_types = 1);

namespace Contributte\Cache;

use Nette\Caching\Cache;

interface ICacheFactory
{

	public function create(string $namespace): Cache;

}
