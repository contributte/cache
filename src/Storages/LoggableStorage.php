<?php declare(strict_types = 1);

namespace Contributte\Cache\Storages;

use Nette\Caching\Storage;

final class LoggableStorage implements Storage
{

	public const KEY_METHOD = 'method';
	public const KEY_KEY = 'key';
	public const KEY_DATA = 'data';
	public const KEY_OPTIONS = 'options';

	private Storage $storage;

	/** @var array<string, mixed> */
	private array $options = [
		'maxCalls' => 100,
	];

	/** @var array<int, array{method: string, key: string, data: mixed, options: mixed[]}> */
	private array $calls = [];

	public function __construct(Storage $storage)
	{
		$this->storage = $storage;
	}

	/**
	 * @param mixed[] $options
	 */
	public function setOptions(array $options): void
	{
		$this->options = array_merge($this->options, $options);
	}

	/**
	 * @return array<int, array{method: string, key: string, data: mixed, options: mixed[]}>
	 */
	public function getCalls(): array
	{
		return $this->calls;
	}

	public function read(string $key): mixed
	{
		$data = $this->storage->read($key);

		$this->addLog(__FUNCTION__, $key, $data);

		return $data;
	}

	public function lock(string $key): void
	{
		$this->addLog(__FUNCTION__, $key);

		$this->storage->lock($key);
	}

	/**
	 * @param mixed[] $dependencies
	 */
	public function write(string $key, mixed $data, array $dependencies): void
	{
		$this->addLog(__FUNCTION__, $key, $data, ['dependencies' => $dependencies]);

		$this->storage->write($key, $data, $dependencies);
	}

	public function remove(string $key): void
	{
		$this->addLog(__FUNCTION__, $key);

		$this->storage->remove($key);
	}

	/**
	 * @param mixed[] $conditions
	 */
	public function clean(array $conditions): void
	{
		$this->addLog(__FUNCTION__, '', ['conditions' => $conditions]);

		$this->storage->clean($conditions);
	}

	/**
	 * @param mixed[] $options
	 */
	private function addLog(string $method, string $key, mixed $data = null, array $options = []): void
	{
		$this->calls[] = [
			self::KEY_METHOD => $method,
			self::KEY_KEY => $key,
			self::KEY_DATA => $data,
			self::KEY_OPTIONS => $options,
		];

		if (count($this->calls) > $this->options['maxCalls']) {
			array_shift($this->calls);
		}
	}

}
