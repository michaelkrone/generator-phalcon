<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\View,
	\Phalcon\Loader,
	\Phalcon\Http\ResponseInterface,
	\Phalcon\Events\Manager as EventsManager,
	\Phalcon\Session\Adapter\Files as SessionAdapter,
	\<%= project.namespace %>\Application\Router\ApplicationRouter;

/**
 * Application class for multi module applications
 * including HMVC internal requests.
 */
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
		 * necessary for redirecting HMVC requests
		 */
		parent::setDI($di);
        $di->set('app', $this);


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
	 * Register the services here to make them general or register in the
	 * ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{
		/**
		 * The application wide configuration
		 */
		$config = include __DIR__ . '/../../../config/config.php';
		$this->di->set('config', $config);

		/**
		 * Setup an events manager with priorities enabled
		 */
		$eventsManager = new EventsManager();
		$eventsManager->enablePriorities(true);
		$this->setEventsManager($eventsManager);

        /**
         * Register namespaces for application classes
         */
        $loader = new Loader();
        $loader->registerNamespaces([
                'GastroKey\Application' => __DIR__,
                'GastroKey\Application\Controllers' => __DIR__ . '/controllers/',
                'GastroKey\Application\Models' => __DIR__ . '/models/',
                'GastroKey\Application\Router' => __DIR__ . '/router/'
            ], true)
            ->register();

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
		$this->di->set('router', new ApplicationRouter());

		/**
		 * Specify the use of metadata adapter
		 */
		$this->di->set('modelsMetadata', '\Phalcon\Mvc\Model\Metadata\\' . $config->application->models->metadata->adapter);
	}

	/**
	 * Register the given modules in the parent and prepare to load
	 * the module routes by triggering the init routes method
	 */
	public function registerModules($modules, $merge = null)
	{
		parent::registerModules($modules, $merge);
		$loader = new Loader();
		$modules = $this->getModules();

		foreach ($modules as $module) {
			$className = $module['className'];
			if ( $loader->registerClasses([ $className => $module['path'] ], true)->register()->autoLoad($className) ) {
				/** @var \<%= project.namespace %>\Application\ApplicationModule $className */
				$className::initRoutes($this->di);
			}
		}
	}

	/**
	 * Handles the request and echoes its content to the output stream.
	 */
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
      * @param array $location Array with the route information: 'controller', 'action', 'params'
      * @param array $data Additional request meta data (not used yet)
      * @return mixed
      */
    public function request(array $location, array $data = null)
    {
        $dispatcher = clone $this->di->get('dispatcher');
		$response = $dispatcher
			->setControllerName(isset($location['controller']) ? $location['controller'] : 'index')
			->setActionName(isset($location['action']) ? $location['action'] : 'index')
			->setParams(isset($location['params']) ? (array) $location['params'] : [])
        	->dispatch()
        	->getReturnedValue();

        if ($response instanceof ResponseInterface) {
			return $response->getContent();
        }

		return $response;
    }

}
