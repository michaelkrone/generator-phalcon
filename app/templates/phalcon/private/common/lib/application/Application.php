<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\DI\FactoryDefault,
	\Phalcon\Mvc\View,
	\Phalcon\Loader,
	\Phalcon\Session\Adapter\Files as SessionAdapter;

class Application extends \Phalcon\Mvc\Application
{
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{
		$loader = new Loader();
		$loader->registerNamespaces(array(
			'<%= project.namespace %>\Controllers' => __DIR__ . '/../controllers/'
		))->register();

		$di = new FactoryDefault();

		/**
		 * The application wide configuration
		 */
		$config = include __DIR__ . '/../../../config/config.php';
		$di->set('config', $config);

		/**
		 * Start the session the first time some component request the session service
		 */
		$di->set('session', function () {
			$session = new SessionAdapter();
			$session->start();
			return $session;
		});

		/**
		 * Registering a router
		 */
		$di->set('router', include __DIR__ . '/../../../config/routes.php');

		/**
		 * Specify the use of metadata adapter
		 */
		$di->set('modelsMetadata', function () use ($config) {
			$metaDataConfig = $config->application->models->metadata;
			$metadataAdapter = '\Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
			return new $metadataAdapter();
		});

		$this->setDI($di);
	}

	public function main()
	{
		$this->_registerServices();

		/**
		 * Register the installed modules
		 */
		$this->registerModules(require __DIR__ . '/../../../config/modules.php');

		echo $this->handle()->getContent();
	}
}
