<?php

namespace <%= project.namespace %>\<%= module.namespace %>;

use \Phalcon\Loader,
	\Phalcon\DI,
	\Phalcon\Mvc\View,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\Events\Manager,
	\Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	\<%= project.namespace %>\Interfaces\ApplicationModule;

class Module extends ApplicationModule
{
	/**
	 * Perform any pre module init customer specific logic here.
	 */
    public static function initCustomerConfiguration() {
    	// @TODO: Insert customer configuration code
    }

	/**
	 * Perform any pre module init logic here,
	 * register the module specific configuration classes
	 */
	public static function initConfiguration() {
		$loader = new Loader();
		$loader->registerNamespaces([
				'<%= project.namespace %>\<%= module.namespace %>\Config' => __DIR__ . '/config/'
				], true)
			->register();

		/**
		 * Mount the module specific routes
		 */
		DI::getDefault()->getRouter()->mount(new Config\ModuleRoutes());
	}

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();
		$loader->registerNamespaces([
				'<%= project.namespace %>\<%= module.namespace %>\Config' => __DIR__ . '/config/',
				'<%= project.namespace %>\<%= module.namespace %>\Controllers' => __DIR__ . '/controllers/',
				'<%= project.namespace %>\<%= module.namespace %>\Models' => __DIR__ . '/models/',
				'<%= project.namespace %>\<%= module.namespace %>\Library' => __DIR__ . '/lib/',
			], true)
			->register();
	}
	
	/**
	 * Registers the module-only services
	 *
	 * @param Phalcon\DiInterface $di
	 */
	public function registerServices($di)
	{
		/**
		 * Read configurations
		 */
		$appConfig = $di->get('config');

		/**
		 * Setting up the view component
		 */
		$di->set('view', function() {
			$view = new View();
			$view->setViewsDir(<%= module.viewsDir %>);
			$view->setLayoutsDir('../../layouts/');
			$view->setPartialsDir('../../partials/');
			$view->registerEngines(['.html' => 'Phalcon\Mvc\View\Engine\Php']);
			return $view;
		});

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set('url', function () use ($appConfig) {
			$url = new UrlResolver();
			$url->setBaseUri($appConfig->application->baseUri);
			return $url;
		});

		/**
		 * Module specific dispatcher
		 */
		$di->set('dispatcher', function () {
        	$dispatcher = new Dispatcher();
	        $eventsManager = new Manager();
	        $dispatcher->setEventsManager($eventsManager);
			$dispatcher->setDefaultNamespace('<%= project.namespace %>\<%= module.namespace %>\\');
			return $dispatcher;
		});

		/**
		 * Module specific database connection
		 */
		$di->set('db', function() use ($appConfig) {
			return new DbAdapter([
				'host' => $appConfig->database->host,
				'username' => $appConfig->database->username,
				'password' => $appConfig->database->password,
				'dbname' => $appConfig->database->name
			]);
		});
	}
}
