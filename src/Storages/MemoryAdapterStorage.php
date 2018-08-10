<?php declare(strict_types = 1);

namespace Contributte\Cache\Storages;

use Nette\Caching\IStorage;
use Nette\Caching\Storages\MemoryStorage;

class MemoryAdapterStorage implements IStorage
{

	/** @var IStorage */
	private $cachedStorage;

	/** @var MemoryStorage */
	private $memoryStorage;

	public function __construct(IStorage $cachedStorage)
	{
		$this->cachedStorage = $cachedStorage;
		$this->memoryStorage = new MemoryStorage();
	}

	/**
	 * Read from cache.
	 *
	 * @param string $key
	 * @return mixed|null
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function read($key)
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
	 *
	 * @param string $key
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function lock($key): void
	{
		$this->cachedStorage->lock($key);
		// Not implemented by MemoryStorage
	}

	/**
	 * Writes item into the cache.
	 *
	 * @param string  $key
	 * @param mixed   $data
	 * @param mixed[] $dependencies
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function write($key, $data, array $dependencies): void
	{
		$this->cachedStorage->write($key, $data, $dependencies);
		$this->memoryStorage->write($key, $data, $dependencies);
	}

	/**
	 * Removes item from the cache.
	 *
	 * @param string $key
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function remove($key): void
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
