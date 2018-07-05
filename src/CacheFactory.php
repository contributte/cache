<?php declare(strict_types = 1);

namespace Contributte\Cache;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;

class CacheFactory implements ICacheFactory
{

	/** @var IStorage */
	private $storage;

	public function __construct(IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function create(string $namespace): Cache
	{
		return new Cache($this->storage, $namespace);
	}

}
