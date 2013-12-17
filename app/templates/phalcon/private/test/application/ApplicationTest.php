<?php

namespace <%= project.namespace %>\Test;

use \Phalcon\DI,
	<%= project.namespace %>\Test\Helper\UnitTestCase;

/**
 * Test class for <%= project.namespace %> Application class
 */
class ApplicationTest extends UnitTestCase
{

	/**
	 * Test service registration
	 *
	 * @covers <%= project.namespace %>\Application\Application::_registerServices
	 */
	public function testServices()
	{
		$this->assertInstanceOf('\Phalcon\Mvc\Router', $this->application->di->get('router'));
		$this->assertInstanceOf('\Phalcon\Session\Adapter', $this->application->di->get('session'));
		$this->assertInstanceOf('\Phalcon\Mvc\Model\MetaData', $this->application->di->get('modelsMetadata'));
		$this->assertInstanceOf('\Phalcon\Annotations\Adapter', $this->application->di->get('annotations'));
		$this->assertInstanceOf('\Phalcon\Events\Manager', $this->application->getEventsManager());
	}

	/**
	 * Simple test for registerModules method
	 *
	 * @covers <%= project.namespace %>\Application\Application::registerModules
	 */
	public function testRegisterModules()
	{
		$this->assertCount(1, $this->application->getModules());
		$this->assertArrayHasKey('<%= module.slug %>', $this->application->getModules());
	}

	/**
	 * Test applicaton HMVC request
	 *
	 * @covers <%= project.namespace %>\Application\Application::request
	 */
	public function testApplicationRequest()
	{
		$this->assertNull(
			$this->application->request([
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API',
				'module' => '<%= module.slug %>',
				'controller' => 'index',
				'action' => 'index'
			])
		);
	}

	/**
	 * Test application instance matches the app service
	 *
	 * @covers <%= project.namespace %>\Application\Application::__construct
	 */
	public function testApplicationService()
	{
		$this->assertEquals($this->application, $this->application->di->get('app'));
	}
}
