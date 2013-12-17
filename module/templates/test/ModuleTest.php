<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Test;

use Phalcon\DI,
	<%= project.namespace %>\<%= module.namespace %>\Test\Helper\ModuleUnitTestCase;

/**
 * Test class for <%= module.namespace %> Module class
 */
class ModuleTest extends ModuleUnitTestCase {

	/**
	 * Test class for module routes
	 * @covers <%= project.namespace %>\<%= module.namespace %>\Module::initRoutes
	 */
	public function testModuleRoutes()
	{
		$di = $this->application->di;
		$router = $di->get('router');

	    $router->handle('/');
	    $this->assertEquals('<%= module.slug %>', $router->getModuleName());
	    $this->assertEquals('index', $router->getControllerName());
	    $this->assertEquals('index', $router->getActionName());
	}
}
