<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\View,
	\Phalcon\Loader,
	\Phalcon\Session\Adapter\Files as SessionAdapter,
	\Phalcon\Http\ResponseInterface;

class Application extends \Phalcon\Mvc\Application
{
	/**
     * Application Constructor
     *
	 * @param \Phalcon\DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
		/**
		 * Sets the parent DI and register the app itself as a service,
		 * neccessary for redirecting HMVC requests
		 */
		parent::setDI($di);
        $di->set('app', $this);

        /**
         * Register namespaces for application classes
         */
        $loader = new Loader();
		$loader->registerNamespaces([
				'<%= project.namespace %>\Application' => __DIR__,
				'<%= project.namespace %>\Controllers' => __DIR__ . '/../controllers/',
				'<%= project.namespace %>\Interfaces' => __DIR__ . '/../interfaces/'
			], true)
			->register();

		/**
		 * Register application wide accessible services
		 */
		$this->_registerServices();

		/**
		 * Register the installed/configured modules
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
		 * Registering the application wide router with the standard routes set
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

	/**
	 * Register the given modules in the parent and prepare to load the module definition classes
	 * by triggering the pre load configuration with the initConfiguration method
	 */
	public function registerModules($modules, $merge = null)
	{
		parent::registerModules($modules, $merge);
		$loader = new Loader();
		$modules = $this->getModules();

		foreach ($modules as $module) {
			if ($loader->registerClasses([ $module['className'] => $module['path'] ], true)
					->register()
					->autoLoad($module['className'])
			) {
				$module['className']::initConfiguration();
			}
		}
	}

	public function main()
	{
		echo $this->handle()->getContent();
	}

	 /**
     * Does a HMVC request inside the application
     *
     * Inside a controller we might do
     * <code>
     * $this->app->request([ 'controller' => 'do', 'action' => 'something' ], 'param');
     * </code>
     *
     * @param array $location
     * @param array $data
     * @return mixed
     */
    public function request($location, $data = null)
    {
        $dispatcher = clone $this->di->get('dispatcher');

        if (isset($location['controller'])) {
			$dispatcher->setControllerName($location['controller']);
        } else {
			$dispatcher->setControllerName('index');
        }

        if (isset($location['action'])) {
			$dispatcher->setActionName($location['action']);
        } else {
			$dispatcher->setActionName('index');
        }

        if (isset($location['params'])) {
			if(is_array($location['params'])) {
				$dispatcher->setParams($location['params']);
			} else {
				$dispatcher->setParams((array) $location['params']);
			}
        } else {
        	$dispatcher->setParams(array());
        }

        $dispatcher->dispatch();

        $response = $dispatcher->getReturnedValue();
        
        if ($response instanceof ResponseInterface) {
			return $response->getContent();
        }

		return $response;
    }

}
