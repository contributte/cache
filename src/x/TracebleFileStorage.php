<?php

namespace Contributte\Caching;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Caching\Storages\FileStorage;

class TracebleFileStorage implements IStorage
{

	/** @var FileStorage */
	private $storage;

	/** @var Cache */
	private $cache;

	/**
	 * @param FileStorage $storage
	 */
	public function __construct(FileStorage $storage)
	{
		$this->storage = $storage;
		$this->cache = new Cache($storage);
	}

	/**
	 * Read from cache.
	 *
	 * @param  string
	 * @return mixed
	 */
	public function read($key)
	{
		return $this->storage->read($key);
	}

	/**
	 * Prevents item reading and writing. Lock is released by write() or remove().
	 *
	 * @param  string
	 * @return void
	 */
	public function lock($key)
	{
		$this->storage->lock($key);
	}

	/**
	 * Writes item into the cache.
	 *
	 * @param  string
	 * @param  mixed
	 * @return void
	 */
	public function write($key, $data, array $dependencies)
	{
		$this->cache->save();
		$this->storage->write($key, $data, $dependencies);
	}

	/**
	 * Removes item from the cache.
	 *
	 * @param  string
	 * @return void
	 */
	public function remove($key)
	{
		$this->storage->remove($key);
	}

	/**
	 * Removes items from the cache by conditions.
	 *
	 * @param  array  conditions
	 * @return void
	 */
	public function clean(array $conditions)
	{
		$this->storage->clean($conditions);
	}
}