<?php

namespace Contributte\Caching;

use Nette\Utils\Finder;
use SplFileInfo;

final class CacheFinder
{

	/** @var string */
	private $dir;

	/**
	 * @param string $dir
	 */
	public function __construct($dir)
	{
		$this->dir = $dir;
	}

	/**
	 * @return array
	 */
	public function collect()
	{
		$output = [];
		$dirs = Finder::findDirectories('_*')->from($this->dir);

		foreach ($dirs as $dir) {
			$files = Finder::findFiles('_*')->in($dir);

			/** @var SplFileInfo[] $files */
			foreach ($files as $file) {
				$output[] = $file->getRealPath();
			}
		}

		return $output;
	}

}