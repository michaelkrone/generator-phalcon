<?php

namespace <%= project.namespace %>\Application\Router;

use \Phalcon\Mvc\Router;

/**
 * This class acts as the application router and defines global application routes.
 * Module specific routes are defined inside the ModuleRoutes classes.
 */
class ApplicationRouter extends Router {

	/**
	 * Creates a new instance of ApplicationRouter class and defines standard application routes
	 * @param boolean $defaultRoutes
	 */
	public function __construct($defaultRoutes = false) {
		parent::__construct($defaultRoutes);

		$this->removeExtraSlashes(true);

		/**
		 * Controller and action always default to 'index' 
		 */
		$this->setDefaults([
		    'controller' => 'index',
		    'action' => 'index'
		]);

		/**
		 * Add global matching route for the default module '<%= module.namespace %>': 'default-route'
		 */
		$this->add('/', [
			'module' => '<%= module.slug %>',
			'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\'
		])->setName('default-route');

		/**
		 * Add default not found route
		 */
		$this->notFound([
		    'controller' => 'index',
		    'action' => 'route404'
		]);
	}
}
