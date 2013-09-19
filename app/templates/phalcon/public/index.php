<?php

namespace <%= project.namespace %>;

use \Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\DI\FactoryDefault,
	\Phalcon\Session\Adapter\Files as SessionAdapter;

error_reporting(E_ALL);

class Application extends \Phalcon\Mvc\Application
{
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{
		$di = new \Phalcon\DI\FactoryDefault();

		/**
		 * The application wide configuration
		 */
		$config = include __DIR__ . '/../private/config/config.php';

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
		$di->set('router', require __DIR__ . '/../private/config/routes.php');

		/**
		 * If the configuration specify the use of metadata adapter use it or use memory otherwise
		 */
		$di->set('modelsMetadata', function () use ($config) {
			$metaDataConfig = $config->application->models->metadata;
			$metadataAdapter = '\Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
			return new $metadataAdapter();
		});

		/**
		 * We're a registering a set of directories taken from the configuration file
		 $loader = new \Phalcon\Loader();
		 $loader->registerDirs(array(__DIR__ . '/../apps/library/'))->register();		
		 */

		$this->setDI($di);
	}

	public function main()
	{
		$this->_registerServices();

		/**
		 * Register the installed modules
		 */
		require __DIR__ . '/../private/config/modules.php';

		echo $this->handle()->getContent();
	}
}

try {
	$application = new Application();
	$application->main();
} catch (\Phalcon\Exception $e) {
	echo 'Phalcon\Exception: ', $e->getMessage(), $e->getTraceAsString();
} catch (\PDOException $e) {
	echo 'PDOException: ', $e->getMessage(), $e->getTraceAsString();
} catch (\Exception $e) {
	echo 'Exception: ', $e->getMessage(), $e->getTraceAsString();
}