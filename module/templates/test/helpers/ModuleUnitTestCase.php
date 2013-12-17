<?php
namespace <%= project.namespace %>\<%= module.namespace %>\Test\Helper;

use Phalcon\DI,
	\Phalcon\Test\UnitTestCase as PhalconTestCase,
	\<%= project.namespace %>\Application\Application,
	\<%= project.namespace %>\<%= module.namespace %>\Module;

abstract class ModuleUnitTestCase extends PhalconTestCase {

	/**
	 * @var \Voice\Cache
	 */
	protected $_cache;

	/**
	 * @var \Phalcon\Config
	 */
	protected $_config;

	protected $application;

	/**
	 * @var bool
	 */
	private $_loaded = false;

	public function setUp(\Phalcon\DiInterface $di = null, \Phalcon\Config $config = null)
	{
		// Load any additional services that might be required during testing
		$di = DI::getDefault();
        $this->application = new Application($di);

		// get any DI components here. If you have a config, be sure to pass it to the parent
		parent::setUp($this->application->di, $this->application->config);

		$this->_loaded = true;
	}

	public function tearDown() {
		$this->application = null;
	}

	/**
	 * Check if the test case is setup properly
	 * @throws \PHPUnit_Framework_IncompleteTestError;
	 */
	public function __destruct() {
		if(!$this->_loaded) {
			throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
		}
	}
}