<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Config;

use Phalcon\Mvc\Router\Group;

class ModuleRoutes extends Group
{

	public function initialize()
	{
		/**
		 * Configure the instance
		 */
		$this->setPaths(array(
			'module' => '<%= module.slug %>',
			'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\\'
		));

		/**
		 * In the URI this module is prefixed by /<%= module.slug %> 
		 */
		$this->setPrefix('/<%= module.slug %>');

		/**
		 * Add module specific routes here
		 */
		$this->addGet('/:controller', array(
			'controller' => 1
		))
		->setName('controller-route');

		$this->addGet('/:controller/:action/:params', array(
			'controller' => 1,
			'action' => 2,
			'params' => 3
		))
		->setName('action-route');
	}
}
