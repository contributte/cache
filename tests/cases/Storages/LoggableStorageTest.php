<?php declare(strict_types = 1);

namespace Tests\Cases\Storages;

use Contributte\Cache\Storages\LoggableStorage;
use Nette\Caching\Storages\DevNullStorage;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class LoggableStorageTest extends TestCase
{

	public function testLogging(): void
	{
		$storage = new LoggableStorage(new DevNullStorage());
		$storage->lock('foo');
		$storage->write('foo', '', []);
		$storage->read('foo');
		$storage->remove('foo');
		$storage->clean([]);

		Assert::same(
			[
				[
					'method' => 'lock',
					'key' => 'foo',
					'data' => null,
					'options' => [],
				],
				[
					'method' => 'write',
					'key' => 'foo',
					'data' => '',
					'options' => [
						'dependencies' => [],
					],
				],
				[
					'method' => 'read',
					'key' => 'foo',
					'data' => null,
					'options' => [],
				],
				[
					'method' => 'remove',
					'key' => 'foo',
					'data' => null,
					'options' => [],
				],
				[
					'method' => 'clean',
					'key' => '',
					'data' => [
						'conditions' => [],
					],
					'options' => [],
				],
			],
			$storage->getCalls()
		);
	}

	public function testLimit(): void
	{
		$storage = new LoggableStorage(new DevNullStorage());
		$storage->setOptions([
			'maxCalls' => 1,
		]);
		$storage->lock('foo');
		$storage->lock('bar');
		$storage->lock('baz');

		Assert::same(
			[
				[
					'method' => 'lock',
					'key' => 'baz',
					'data' => null,
					'options' => [],
				],
			],
			$storage->getCalls()
		);
	}

}

(new LoggableStorageTest())->run();
