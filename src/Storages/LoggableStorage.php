<?php declare(strict_types = 1);

namespace Contributte\Cache\Storages;

use Nette\Caching\IStorage;

final class LoggableStorage implements IStorage
{

	public const KEY_METHOD = 'method';
	public const KEY_KEY = 'key';
	public const KEY_DATA = 'data';
	public const KEY_OPTIONS = 'options';

	/** @var IStorage */
	private $storage;

	/** @var mixed[] */
	private $options = [
		'maxCalls' => 100,
	];

	/** @var mixed[] */
	private $calls = [];

	public function __construct(IStorage $storage)
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
	 * @return mixed[]
	 */
	public function getCalls(): array
	{
		return $this->calls;
	}

	/**
	 * @return mixed
	 */
	public function read(string $key)
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
	 * @param mixed   $data
	 * @param mixed[] $dependencies
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function write(string $key, $data, array $dependencies): void
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
	 * @param mixed   $key
	 * @param mixed   $data
	 * @param mixed[] $options
	 */
	private function addLog(string $method, $key, $data = null, array $options = []): void
	{
		$this->calls[] = [
			self::KEY_METHOD => $method,
			self::KEY_KEY => (string) $key,
			self::KEY_DATA => $data,
			self::KEY_OPTIONS => $options,
		];

		if (count($this->calls) > $this->options['maxCalls']) {
			array_shift($this->calls);
		}
	}

}
