<?php

namespace <%= project.namespace %>\Test;

use \Phalcon\DI,
	\Phalcon\Loader,
	<%= project.namespace %>\Test\Helper\UnitTestCase;

/**
 * Test class for <%= project.namespace %> Application class
 */
class ApplicationTest extends UnitTestCase
{
	/**
	 * Test application instance matches the app service
	 *
	 * @covers \<%= project.namespace %>\Application\Application::__construct
	 */
	public function testInternalApplicationService()
	{
		$this->assertEquals($this->application, $this->application->di->get('app'));
	}

	/**
	 * Test service registration
	 *
	 * @covers \<%= project.namespace %>\Application\Application::_registerServices
	 */
	public function testServiceRegistration()
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
	 * @covers \<%= project.namespace %>\Application\Application::registerModules
	 */
	public function testModuleIsRegistered()
	{
		$this->assertArrayHasKey('<%= module.slug %>', $this->application->getModules());
	}

	/**
	 * Test applicaton HMVC request
	 *
	 * @covers \<%= project.namespace %>\Application\Application::request
	 */
	public function testHMVCApplicationRequest()
	{
		$controllerName = 'index';
		$indexCntrl = $this->getController($controllerName);

        $this->assertInstanceOf(
        	'\Phalcon\Mvc\Controller',
        	$indexCntrl,
        	sprintf('Make sure the %sController matches the internal HMVC request.', ucfirst($controllerName))
        );

		$this->assertEquals(
			$indexCntrl->indexAction(),
			$this->application->request([
				'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\API',
				'module' => '<%= module.slug %>',
				'controller' => $controllerName,
				'action' => 'index'
			]),
			sprintf(
				'Assert that calling the %s action of the %sController matches the internal HMVC request.',
				$controllerName,
				ucfirst($controllerName)
			)
		);
	}

	/**
	 * Helper to load the a controller
	 *
	 * @coversNothing
	 */
	public function getController($name)
	{
		$loader = new Loader();
		$loader->registerClasses([
			'\<%= project.namespace %>\<%= module.namespace %>\Controllers\API\\' . ucfirst($name) . 'Controller' => ROOT_PATH . 'modules/<%= module.slug %>/controller/api/'
		])->register();

		$indexCntrl = new \<%= project.namespace %>\<%= module.namespace %>\Controllers\API\IndexController();
		$this->assertNotNull($indexCntrl, 'Make sure the index controller could be loaded');

		return $indexCntrl;
	}
}
