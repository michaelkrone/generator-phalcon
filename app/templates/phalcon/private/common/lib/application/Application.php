<?php

namespace <%= project.namespace %>\Application;

use Phalcon\Mvc\Url as UrlResolver,
	Phalcon\DiInterface,
	Phalcon\Mvc\View,
	Phalcon\Loader,
	Phalcon\Session\Adapter\Files as SessionAdapter;

class Application extends \Phalcon\Mvc\Application
{
	/**
     * Application Constructor
     *
	 * @param $di Phalcon\DiInterface
     */
    public function __construct(DiInterface $di)
    {
        //Register the app itself as a service
        $di->set('app', $this);

		//Sets the parent Id
		parent::setDI($di);

        $loader = new Loader();
		$loader->registerNamespaces([
			'<%= project.namespace %>\Application' => __DIR__,
			'<%= project.namespace %>\Controllers' => __DIR__ . '/../controllers/'
		])->register();

		$this->_registerServices();

		/**
		 * Register the installed modules
		 */
		$this->registerModules(require __DIR__ . '/../../../config/modules.php');
    }

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{
		/**
		 * The application wide configuration
		 */
		$config = include __DIR__ . '/../../../config/config.php';
		$this->di->set('config', $config);

		/**
		 * Start the session the first time some component request the session service
		 */
		$this->di->set('session', function () {
			$session = new SessionAdapter();
			$session->start();
			return $session;
		});

		/**
		 * Registering a router
		 */
		$this->di->set('router', include __DIR__ . '/../../../config/routes.php');

		/**
		 * Specify the use of metadata adapter
		 */
		$this->di->set('modelsMetadata', function () use ($config) {
			$metaDataConfig = $config->application->models->metadata;
			$metadataAdapter = '\Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
			return new $metadataAdapter();
		});
	}

	public function registerModules($modules) {
		parent::registerModules($modules);

		$loader = new Loader();

		/**
		 * Init modules configurations
		 */
		$modules = $this->getModules();
		foreach ($modules as $module) {
			if ($loader->registerClasses([ $module['className'] => $module['path'] ])
				->register()
				->autoLoad($module['className'])
			) {
				$module['className']::initConfiguration();
			}
		}

		unset($modules, $module);
	}

	public function main()
	{
		echo $this->handle()->getContent();
	}
}
