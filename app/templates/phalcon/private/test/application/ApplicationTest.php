<?php

namespace <%= project.namespace %>\Test;

use \Phalcon\DI,
	<%= project.namespace %>\Test\Helper\UnitTestCase;

/**
 * Test class for Application class
 * @covers <%= project.namespace %>\Application\Application
 */
class ApplicationTest extends UnitTestCase {

	public function testRoutes()
	{
		$di = DI::getDefault();
		$router = $di->get('router');

	    $router->handle('/');
	    $this->assertEquals('<%= module.slug %>', $router->getModuleName());
	    $this->assertEquals('index', $router->getControllerName());
	    $this->assertEquals('index', $router->getActionName());
	}
}
