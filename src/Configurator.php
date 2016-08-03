<?php

namespace Sw2\Hotplug;

use Nette;

/**
 * Class Configurator
 *
 * @package Sw2\Hotplug
 */
class Configurator extends Nette\Configurator
{
	/** @var Nette\Caching\Cache */
	private $cache;

	/**
	 * @return Nette\Caching\Cache
	 */
	protected function getCache()
	{
		if ($this->cache === NULL) {
			$cacheStorage = new Nette\Caching\Storages\FileStorage($this->getCacheDirectory());
			$this->cache = new Nette\Caching\Cache($cacheStorage, 'Sw2.HotplugContainer');
		}

		return $this->cache;
	}

	/**
	 * @param string $path
	 */
	public function addPluginDirectory($path)
	{
		$configs = $this->getCache()->load($path);
		if ($configs === NULL) {
			$configs = $this->loadConfigFiles($path);
			$this->getCache()->save($path, $configs, [Nette\Caching\Cache::FILES => $configs]);
		}
		$loader = $this->createLoader();
		foreach ($configs as $file) {
			$config = Helpers::expand($loader->load($file), 'pluginDir', dirname(dirname($file)));
			$this->addConfig($config);
		}
	}

	/**
	 * @param string $path
	 *
	 * @return array
	 */
	private function loadConfigFiles($path)
	{
		$files = [];
		/** @var \SplFileInfo $file */
		foreach (Nette\Utils\Finder::find('config/hotplug.neon')->from($path) as $file) {
			$files[] = $file->getPathname();
		}

		return $files;
	}

}
