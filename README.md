Hotplug - super simple plugins for Nette
========================================

Nette has not any plugin management. If you want to split your application into multiple modules,
you probably use the `includes` section of configuration files. This library will help you simplify
this problem with a nice and simple way.


Requirements
------------

This library requires PHP 5.4 or higher. Hotplug is designed for [Nette Framework](https://github.com/nette/nette).


Installation
------------

The best way to install this library is using  [Composer](http://getcomposer.org/):

```sh
$ composer require sw2eu/hotplug
```


Documentation
-------------

Firstly, you will use Hotplug Configurator in your bootstrap file:

```php
$configurator = new Sw2\Hotplug\Configurator;
```

Now you can define your plugin directory. I use slightly different structure, but it is fully configurable:

```php
$configurator->addPluginDirectory(__DIR__ . '/../src/Plugins');
// place before
$configurator->addConfig(...);
```

The hotplug configurator will search for any `config/hotplug.neon` in defined directory. For exaple:
- `src/Plugins/Admin/config/hotplug.neon`,
- `src/Plugins/Cms/Page/config/hotplug.neon`,
- etc.

That's all! Now you can define your plugin.


Plugin definition
-----------------

Every plugin must have defined configuration file `hotplug.neon`. In this file, you work like in any
configuration file for Nette framework (maybe you can read [configuration section in documentation](https://doc.nette.org/en/2.4/configuring)).

You can also use variable `%pluginDir%` for locating files in your plugin directory, for example assets.

If you need add new router for your plugin, it is also supersimple. In your application config define main application router like this:

```
# main application config
services:
    router: Sw2\Hotplug\Routers\RouterFactory::createRouter
```

Hotplug `RouterFactory` will search for any service with tag `router`. If you need to ensure sort of the routers, just name by alphabetic order.
Or you can use naming conventions like this:

```
# this is in your hotplug.neon
services:
	router.999:
	    class: Nette\Application\Routers\Route
	    arguments: ['<presenter>/<action>[/<id>]', 'Homepage:default']
	    autowired: FALSE
	    tags: [router]
```

Do not forget to set `autowired` to `FALSE`! If you need to add multiple routers and you wand to define as `RouteList`, this library has
a shortcut class `Sw2\Hotplug\Routers\RouteList` for this case:

```
# this is in your hotplug.neon
services:
	router.010:
		class: Sw2\Hotplug\Routers\RouteList('Admin')
		autowired: FALSE
		tags: [router]
		setup:
			- addRoute('admin/sign-in', 'Auth:signIn')
			- addRoute('admin/sign-out', 'Auth:signOut')
			- add(@otherRouterService)
```
