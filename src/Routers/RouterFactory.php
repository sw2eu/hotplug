<?php

namespace Sw2\Hotplug\Routers;

use Nette;

/**
 * Class RouterFactory
 *
 * @package Sw2\Hotplug
 */
class RouterFactory
{

	/**
	 * @param Nette\DI\Container $di
	 *
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter(Nette\DI\Container $di)
	{
		$router = new Nette\Application\Routers\RouteList;
		foreach ($di->findByTag('router') as $name => $hasTag) {
			if ($hasTag) $router[] = $di->getService($name);
		}

		return $router;
	}

}
