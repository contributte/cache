<?php declare(strict_types = 1);

namespace Contributte\Cache\Tracy;

use Contributte\Cache\Storages\LoggableStorage;
use Tracy\IBarPanel;

class StoragePanel implements IBarPanel
{

	/** @var LoggableStorage */
	private $storage;

	/** @var mixed[] */
	private $options = [
		'title' => '%d calls',
		'titleNo' => 'no call',
		'dumpData' => true,
		'dumpOptions' => true,
	];

	public function __construct(LoggableStorage $storage)
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

	public function getTab(): ?string
	{
		$calls = count($this->storage->getCalls());

		return '<span title="Caching storage panel">'
			. '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAupJREFUOI19k0lMU1EUhv97332Pvkdf6AgW0YIQwWic2DghRjQEDSZuTHSlCzckTgu3Lk1caEw0TokL40ZjdEPFKQpOGBYOCAoOiNBoW0uxBdq+vuFeF0QSBT3Lk/98OflyDsF/6sj1UdXWte3AePuZbYsLc2XonJNCkLZIapfldg0IgRuC+/oPdCRbIQT5OzqrcTCSrOfAaRCyYZoFxCYsUAlwSdIbj0J2n90RHJwFaIsk5lHQ4+msuTfPKSGUoLSYwbA4vk2YcCsMtgDm69QmlJwRWX7s3K6yKQoAK059Wmpz2gFC9o0ZnBgOR9bkKNgCmkKhMoqCwxEslsAFvsWmnA0f8/ZKAGAAMFawg3fe/VhRO09/GvYoy5I57nUrFKo8vWCFR4EQmEwb9qsfWWedAA3/IZFwIQQkOhjPNTz4MC6pjD/xq9QGAHAu8hZ/9mnMLCSyolGAyoREh5gyHAMACQBaj/a4FGOgKmMu93Kh+qI/zXAsbY76deXV95ywUjm+WhCiEUxmStQTj8sDV40Fpc97ui9/iTIAcLmsUFX126ZAsu15dLyJjGb2NkyYqOyP50d8xUW1Diyuy9eeety3TX9AXs9osZsKQmYcSJNO3KHShB7iTXWBe/FgovvR19QeL7AdsvSit1S7FA8GzDpFcYXlPM8sicQ66kx/7MRvwKGLheCwZfX1LWf43OxuCFZkm3X/uX5z8tZImd9ya7raDEGcmoeprmW9phXSgxsliYQADLFpk1xaJMtN5X08UTWYftS3WfXEVhat8ZaYKY1p9f73U69XPcgkKhXfkiKvLwwg7RCSnJG4v3JBUpJMmQGbygirDQ/Yae2d8VK4pFx9e3p47WdFK9cDGymjOgEuycLcGb74MDrrlPtbq2uoTU+CYocDCEPRIn5fWQtlYADvdCg7XH3+7tv//gIAvG+p2QpKTiueQJK69YWU4Gjlhfs358rOCQCAzsZGVhHKbWFFWlfVlcfGv3K/ABgGN/kmNNzXAAAAAElFTkSuQmCC"/> '
			. ($calls > 0 ? sprintf($this->options['title'], $calls) : $this->options['titleNo'])
			. ' </span>';
	}

	public function getPanel(): ?string
	{
		ob_start();

		$calls = $this->storage->getCalls();
		$options = $this->options;

		require __DIR__ . '/templates/panel.phtml';

		return ob_get_clean();
	}

}
