<?php

namespace Contributte\Caching;

use Nette\Caching\IStorage;
use Nette\Caching\Storages\FileStorage;
use Nette\Caching\Storages\IJournal;
use Nette\Utils\Arrays;
use ReflectionClass;

final class CacheIntrospection
{

	/** @var CacheFinder */
	private $finder;

	/** @var FileStorage */
	private $storage;

	/** @var IJournal */
	private $journal;

	/**
	 * @param CacheFinder $finder
	 * @param IStorage $storage
	 * @param IJournal|NULL $journal
	 */
	public function __construct(CacheFinder $finder, IStorage $storage, IJournal $journal = NULL)
	{
		$this->finder = $finder;
		$this->storage = $storage;
		$this->journal = $journal;
	}

	/**
	 * @return array
	 */
	public function introspection()
	{
		$files = $this->getFiles();

		$rf = new ReflectionClass(FileStorage::class);
		$readMetaAndLock = $rf->getMethod('readMetaAndLock');
		$readMetaAndLock->setAccessible(TRUE);

		$output = [];
		foreach ($files as $file) {
			$meta = $readMetaAndLock->invoke($this->storage, $file, LOCK_SH);

			$fileparts = explode('/', $file);
			$hash = array_pop($fileparts);
			$namespace = array_pop($fileparts);

			$output[$file] = [
				'file' => $file,
				'key' => '',
				'hash' => $hash,
				'namespace' => $namespace,
				'expire' => Arrays::get($meta, FileStorage::META_EXPIRE, NULL),
				'size' => filesize($file),
				'meta' => $meta,
			];
		}

		return $output;
	}

	/**
	 * @return array
	 */
	public function getFiles()
	{
		return $this->finder->collect();
	}

}
