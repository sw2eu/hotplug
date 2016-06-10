<?php

namespace Sw2\Hotplug;

use Nette;
use Nette\DI\Statement;

/**
 * Class Helpers
 *
 * @package Sw2\Hotplug
 */
class Helpers
{

	/**
	 * @param mixed $config
	 * @param string $name
	 * @param string $value
	 *
	 * @return array|mixed|Statement
	 */
	public static function expand($config, $name, $value)
	{
		if (is_array($config)) {
			$res = [];
			foreach ($config as $key => $val) {
				$res[$key] = self::expand($val, $name, $value);
			}

			return $res;
		}
		elseif ($config instanceof Statement) {
			return new Statement(self::expand($config->getEntity(), $name, $value), self::expand($config->arguments, $name, $value));

		}
		elseif (!is_string($config)) {
			return $config;
		}

		$quotedName = preg_quote($name);

		return preg_replace("#%$quotedName%#", $value, $config);
	}

}
