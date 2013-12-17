<?php
namespace <%= project.namespace %>\Test\Helper;

use Phalcon\DI,
    \Phalcon\Test\UnitTestCase as PhalconTestCase,
    \<%= project.namespace %>\Application\Application;

abstract class UnitTestCase extends PhalconTestCase {

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

        // get any DI components here. If you have a config, be sure to pass it to the parent
        $this->application = new Application($di);

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