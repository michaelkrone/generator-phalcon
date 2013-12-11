<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\View,
	\Phalcon\Loader,
	\Phalcon\Session\Adapter\Files as SessionAdapter,
	\Phalcon\Http\ResponseInterface,
	\<%= project.namespace %>\Application\Router\ApplicationRouter;

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
         * Register namespaces for application classes since they are used
         * in the modules definitions
         */
        $loader = new Loader();
        $loader->registerNamespaces([
                'GastroKey\Application' => __DIR__,
                'GastroKey\Application\Controllers' => __DIR__ . '/controllers/',
                'GastroKey\Application\Interfaces' => __DIR__ . '/interfaces/',
                'GastroKey\Application\Models' => __DIR__ . '/models/',
                'GastroKey\Application\Router' => __DIR__ . '/router/'
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
		$this->di->set('router', new ApplicationRouter());

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
	 * by triggering the pre load configuration with the initConfiguration method if the module
	 * is an instance of <%= project.namespace %>\Application\Interfaces\ConfigurationInitable
	 */
	public function registerModules($modules, $merge = null)
	{
		parent::registerModules($modules, $merge);
		$loader = new Loader();
		$modules = $this->getModules();

		foreach ($modules as $module) {
			$cName = $module['className'];
			if ($loader->registerClasses([ $cName => $module['path'] ], true)
					->register()
					->autoLoad($cName)
	            && is_subclass_of($cName, '\<%= project.namespace %>\Application\Interfaces\ConfigurationInitable')
			) {
				/**
	             * @var \<%= project.namespace %>\Application\Interfaces\ConfigurationInitable $cName
	             */
				$cName::initConfiguration($this->di, $this->config);
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
		$dispatcher->setControllerName(isset($location['controller']) ? $location['controller'] : 'index');
		$dispatcher->setActionName(isset($location['action']) ? $location['action'] : 'index');
		$dispatcher->setParams(isset($location['params']) ? (array) $location['params'] : []);
        $dispatcher->dispatch();

        $response = $dispatcher->getReturnedValue();
        
        if ($response instanceof ResponseInterface) {
			return $response->getContent();
        }

		return $response;
    }

}
