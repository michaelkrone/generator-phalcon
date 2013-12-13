<?php

namespace <%= project.namespace %>\<%= module.namespace %>;

use \Phalcon\Mvc\Router\Group;

/**
 * This class defines routes for the <%= project.namespace %>\<%= module.namespace %> module
 * which will be prefixed with '/<%= module.slug %>'
 */
class ModuleRoutes extends Group
{
	/**
	 * Initialize the router group for the <%= module.namespace %> module
	 */
	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by '/<%= module.slug %>'
		 */
		$this->setPrefix('/<%= module.slug %>');

		/**
		 * Configure the instance
		 */
		$this->setPaths([
			'module' => '<%= module.slug %>',
			'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\',
			'controller' => 'index',
			'action' => 'index'
		]);

		/**
		 * Default route: '<%= module.slug %>-root'
		 */
		$this->addGet('', [])
			->setName('<%= module.slug %>-root');

		/**
		 * Controller route: '<%= module.slug %>-controller'
		 */
		$this->addGet('/:controller', ['controller' => 1])
			->setName('<%= module.slug %>-controller');

		/**
		 * Action route: '<%= module.slug %>-action'
		 */
		$this->addGet('/:controller/:action/:params', [
				'controller' => 1,
				'action' => 2,
				'params' => 3
			])
			->setName('<%= module.slug %>-action');

		/**
		 * Add all <%= project.namespace %>\<%= module.namespace %> specific routes here
		 */
	}
}