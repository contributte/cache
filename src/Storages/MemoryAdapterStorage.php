<?php declare(strict_types = 1);

namespace Contributte\Cache\Storages;

use Nette\Caching\Storage;
use Nette\Caching\Storages\MemoryStorage;

class MemoryAdapterStorage implements Storage
{

	private Storage $cachedStorage;

	private MemoryStorage $memoryStorage;

	public function __construct(Storage $cachedStorage)
	{
		$this->cachedStorage = $cachedStorage;
		$this->memoryStorage = new MemoryStorage();
	}

	/**
	 * Read from cache.
	 */
	public function read(string $key): mixed
	{
		// Get data from memory storage
		$data = $this->memoryStorage->read($key);
		if ($data !== null) {
			return $data;
		}

		// Get data from cached storage and write them to memory storage
		$data = $this->cachedStorage->read($key);
		if ($data !== null) {
			$this->memoryStorage->write($key, $data, []);
		}

		return $data;
	}

	/**
	 * Prevents item reading and writing. Lock is released by write() or remove().
	 */
	public function lock(string $key): void
	{
		$this->cachedStorage->lock($key);
		// Not implemented by MemoryStorage
	}

	/**
	 * Writes item into the cache.
	 *
	 * @param mixed[] $dependencies
	 */
	public function write(string $key, mixed $data, array $dependencies): void
	{
		$this->cachedStorage->write($key, $data, $dependencies);
		$this->memoryStorage->write($key, $data, $dependencies);
	}

	/**
	 * Removes item from the cache.
	 */
	public function remove(string $key): void
	{
		$this->cachedStorage->remove($key);
		$this->memoryStorage->remove($key);
	}

	/**
	 * Removes items from the cache by conditions.
	 *
	 * @param mixed[] $conditions
	 */
	public function clean(array $conditions): void
	{
		$this->cachedStorage->clean($conditions);
		$this->memoryStorage->clean($conditions);
	}

}
