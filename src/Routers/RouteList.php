<?php

namespace Sw2\Hotplug\Routers;

use Nette;

/**
 * Class RouteList
 *
 * @package Sw2\Hotplug
 */
class RouteList extends Nette\Application\Routers\RouteList
{

	/**
	 * @param Nette\Application\IRouter $router
	 */
	public function add(Nette\Application\IRouter $router)
	{
		$this[] = $router;
	}

	/**
	 * @param string $mask
	 * @param array $metadata
	 * @param int $flags
	 */
	public function addRoute($mask, $metadata = [], $flags = 0)
	{
		$this[] = new Nette\Application\Routers\Route($mask, $metadata, $flags);
	}

}
