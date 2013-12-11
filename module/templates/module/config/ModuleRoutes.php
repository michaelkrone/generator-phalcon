<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Config;

use \Phalcon\Mvc\Router\Group;

class ModuleRoutes extends Group
{

	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by /<%= module.slug %> 
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
		 * Add module specific routes here
		 */
		$this->addGet('/:controller', [
			'controller' => 1
		])->setName('<%= module.slug %>-default-route');

		$this->addGet('/:controller/:action/:params', [
			'controller' => 1,
			'action' => 2,
			'params' => 3
		])->setName('<%= module.slug %>-action-route');
	}
}
