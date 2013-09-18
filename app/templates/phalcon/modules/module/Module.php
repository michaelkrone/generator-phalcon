<?php

namespace <%= project.namespace %>\<%= module.namespace %>;

use Phalcon\Loader,
	Phalcon\Mvc\View,
	Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	Phalcon\Mvc\ModuleDefinitionInterface,
	Phalcon\Mvc\Router\Group;

class Module implements ModuleDefinitionInterface
{

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();

		$loader->registerNamespaces(array(
			'<%= project.namespace %>\<%= module.namespace %>\Config' => __DIR__ . '/config/',
			'<%= project.namespace %>\<%= module.namespace %>\Controllers' => __DIR__ . '/controllers/',
			'<%= project.namespace %>\<%= module.namespace %>\Models' => __DIR__ . '/models/',
		));

		$loader->register();
	}

	/**
	 * Registers the module-only services
	 *
	 * @param Phalcon\DI $di
	 */
	public function registerServices($di)
	{
		/**
		 * Read configuration
		 */
		$config = include __DIR__ . '/config/config.php';

		/**
		 * Setting up the view component
		 */
		$di['view'] = function() {
			$view = new View();
			$view->setViewsDir(<%= module.viewsDir %>);
			$view->registerEngines(
				array('.html' => 'Phalcon\Mvc\View\Engine\Php')
        	);
			return $view;
		};

		/**
		 * Register module specific routes
		 */
		$di['router']->mount(new Config\ModuleRoutes());

		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		$di['db'] = function() use ($config) {
			return new DbAdapter(array(
				'host' => $config->database->host,
				'username' => $config->database->username,
				'password' => $config->database->password,
				'dbname' => $config->database->name
			));
		};
	}
}
