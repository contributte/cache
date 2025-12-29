<?php declare(strict_types = 1);

namespace Contributte\Cache;

use Nette\Caching\Cache;
use Nette\Caching\Storage;

class CacheFactory implements ICacheFactory
{

	private Storage $storage;

	public function __construct(Storage $storage)
	{
		$this->storage = $storage;
	}

	public function create(string $namespace): Cache
	{
		return new Cache($this->storage, $namespace);
	}

}
