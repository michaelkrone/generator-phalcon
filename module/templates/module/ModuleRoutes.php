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
		$this->setPaths(
			[
				'module' => '<%= module.slug %>',
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\View\\',
				'controller' => 'index',
				'action' => 'index'
			]
		);

		/**
		 * Default route: '<%= module.slug %>-api-root'
		 */
		$this->addGet(
			'/api',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\'
			]
		)->setName('<%= module.slug %>-api-root');

		/**
		 * API Controller route: '<%= module.slug %>-api-controller'
		 */
		$this->addGet(
			'/api/:controller',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\',
				'controller' => 1
			]
		)->setName('<%= module.slug %>-api-controller');

		/**
		 * API Action route: '<%= module.slug %>-api-action'
		 */
		$this->addGet(
			'/api/:controller/:action/:params',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\',
				'controller' => 1,
				'action' => 2,
				'params' => 3
			]
		)->setName('<%= module.slug %>-api-action');

		/**
		 * Default route: '<%= module.slug %>-view-root'
		 */
		$this->addGet(
			'/view',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\View\\'
			]
		)->setName('<%= module.slug %>-view-root');

		/**
		 * View Controller route: '<%= module.slug %>-view-controller'
		 */
		$this->addGet(
			'/view/:controller',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\View\\',
				'controller' => 1
			]
		)->setName('<%= module.slug %>-view-controller');

		/**
		 * View Action route: '<%= module.slug %>-view-action'
		 */
		$this->addGet(
			'/api/:controller/:action/:params',
			[
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\View\\',
				'controller' => 1,
				'action' => 2,
				'params' => 3
			]
		)->setName('<%= module.slug %>-view-action');

		/**
		 * Add all <%= project.namespace %>\<%= module.namespace %> specific routes here
		 */
	}
}
