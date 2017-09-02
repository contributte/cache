<?php

namespace Contributte\Caching;

use Tracy\IBarPanel;

final class CachePanel implements IBarPanel
{

	/** @var CacheIntrospection */
	private $introspection;

	/**
	 * @param CacheIntrospection $introspection
	 */
	public function __construct(CacheIntrospection $introspection)
	{
		$this->introspection = $introspection;
	}

	/**
	 * Renders HTML code for custom tab.
	 *
	 * @return string
	 */
	public function getTab()
	{
		ob_start();
		$bytes = 0;
		foreach ($this->introspection->getFiles() as $file) {
			$bytes += filesize($file);
		}
		require __DIR__ . '/templates/tab.phtml';

		return ob_get_clean();
	}

	/**
	 * Renders HTML code for custom panel.
	 *
	 * @return string
	 */
	public function getPanel()
	{
		ob_start();
		$introspection = $this->introspection->introspection();
		require __DIR__ . '/templates/panel.phtml';

		return ob_get_clean();
	}

	/**
	 * Template ****************************************************************
	 */

	/**
	 * @param int $bytes
	 * @param int $precision
	 * @return string
	 */
	public static function templateBytes($bytes, $precision = 2)
	{
		$bytes = round($bytes);
		$units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
		foreach ($units as $unit) {
			if (abs($bytes) < 1024 || $unit === end($units)) {
				break;
			}
			$bytes = $bytes / 1024;
		}

		return round($bytes, $precision) . ' ' . $unit;
	}

}