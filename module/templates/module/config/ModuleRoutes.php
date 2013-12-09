<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Config;

use Phalcon\Mvc\Router\Group;

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
		$this->setPaths(array(
			'module' => '<%= module.slug %>',
			'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\\',
			'controller' => 'index',
			'action' => 'index'
		));

		/**
		 * Add module specific routes here
		 */
		$this->addGet('/:controller', array(
			'controller' => 1
		))->setName('<%= module.slug %>-controller-route');

		$this->addGet('/:controller/:action/:params', array(
			'controller' => 1,
			'action' => 2,
			'params' => 3
		))->setName('<%= module.slug %>-action-route');
	}
}
