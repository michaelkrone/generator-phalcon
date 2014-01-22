<?php

namespace <%= project.namespace %>\<%= module.namespace %>;

use \Phalcon\Loader,
	\Phalcon\DI,
	\Phalcon\Mvc\View,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\Config,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	\<%= project.namespace %>\Application\ApplicationModule;

/**
 * Application module definition for multi module application
 * Defining the <%= module.namespace %> module 
 */
class Module extends ApplicationModule
{
	/**
	 * Mount the module specific routes before the module is loaded.
	 * Add ModuleRoutes Group and annotated controllers for parsing their routing information.
	 *
	 * @param \Phalcon\DiInterface  $di
	 */
	public static function initRoutes(DiInterface $di)
	{
		$loader = new Loader();
		$loader->registerNamespaces(
			[
				'<%= project.namespace %>\<%= module.namespace %>' => __DIR__,
				'<%= project.namespace %>\<%= module.namespace %>\Controllers' => __DIR__ . '/controllers/',
				'<%= project.namespace %>\<%= module.namespace %>\Controllers\API' => __DIR__ . '/controllers/api/',
				'<%= project.namespace %>\<%= module.namespace %>\Controllers\View' => __DIR__ . '/controllers/view/',
				'<%= project.namespace %>\<%= module.namespace %>\Library\Controllers' => __DIR__ . '/lib/controllers'
			],
			true
		)->register();

		/**
		 * Add ModuleRoutes Group and annotated controllers for parsing their routing information.
		 * Be aware that the parsing will only be triggered if the request URI matches the third
		 * parameter of addModuleResource.
		 */
		$router = $di->getRouter();
		$router->mount(new ModuleRoutes());

	 	/**
	 	 * Read names of annotated controllers from the module config and add them to the router
	 	 */
		$moduleConfig = include __DIR__ . '/config/config.php';
		if ( isset($moduleConfig['controllers']['annotationRouted']) ) {
			foreach ($moduleConfig['controllers']['annotationRouted'] as $ctrl) {
				$router->addModuleResource('<%= module.slug %>', $ctrl, '/<%= module.slug %>');	
			}
		}
	}

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();
		$loader->registerNamespaces(
			[
				'<%= project.namespace %>\<%= module.namespace %>' => __DIR__,
				'<%= project.namespace %>\<%= module.namespace %>\Controllers' => __DIR__ . '/controllers/',
				'<%= project.namespace %>\<%= module.namespace %>\Controllers\API' => __DIR__ . '/controllers/api/',
				'<%= project.namespace %>\<%= module.namespace %>\Controllers\View' => __DIR__ . '/controllers/view/',
				'<%= project.namespace %>\<%= module.namespace %>\Models' => __DIR__ . '/models/',
				'<%= project.namespace %>\<%= module.namespace %>\Library' => __DIR__ . '/lib/',
				'<%= project.namespace %>\<%= module.namespace %>\Library\Models' => __DIR__ . '/lib/models',
				'<%= project.namespace %>\<%= module.namespace %>\Library\Controllers' => __DIR__ . '/lib/controllers'
			],
			true
		)->register();
	}
	
	/**
	 * Registers the module-only services
	 *
	 * @param \Phalcon\DiInterface $di
	 */
	public function registerServices($di)
	{
		/**
		 * Read application wide and module only configurations
		 */
		$appConfig = $di->get('config');
		$moduleConfig = include __DIR__ . '/config/config.php';

		$di->set('moduleConfig', $moduleConfig);

		/**
		 * Setting up the view component
		 */
		$di->set(
			'view',
			function() {
				$view = new View();
				$view->setViewsDir(<%= module.viewsDir %>)
					->setLayoutsDir('../../../layouts/')
					->setPartialsDir('../../../partials/')
					->setTemplateAfter('main')
					->registerEngines(['.html' => 'Phalcon\Mvc\View\Engine\Php']);
				return $view;
			}
		);

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set(
			'url',
			function () use ($appConfig) {
				$url = new UrlResolver();
				$url->setBaseUri($appConfig->application->baseUri);
				return $url;
			}
		);

		/**
		 * Module specific dispatcher
		 */
		$di->set(
			'dispatcher',
			function () use ($di) {
				$dispatcher = new Dispatcher();
				$dispatcher->setEventsManager($di->getShared('eventsManager'));
				$dispatcher->setDefaultNamespace('<%= project.namespace %>\<%= module.namespace %>\\');
				return $dispatcher;
			}
		);

		/**
		 * Module specific database connection
		 */
		$di->set(
			'db',
			function() use ($moduleConfig) {
				return new DbAdapter(
					[
						'host' => $moduleConfig->database->host,
						'username' => $moduleConfig->database->username,
						'password' => $moduleConfig->database->password,
						'dbname' => $moduleConfig->database->dbname
					]
				);
			}
		);

		/**
		 * Module specific database connection
		 */
		$di->set(
			'mongo',
			function () use ($moduleConfig) {
				$mongo = new Mongo($moduleConfig->mongoDB->connectionUrl);
				return $mongo->selectDb($moduleConfig->mongoDB->dbname);
			},
			true
		);
	}
}
