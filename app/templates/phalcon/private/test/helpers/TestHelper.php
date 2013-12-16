<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__ . '/../../');
define('PATH_LIBRARY', __DIR__ . '/common/lib/application/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

/**
 * Use the application autoloader to autoload the required
 * bootstrap and test helper classes
 */
$loader = new \Phalcon\Loader();
$loader->registerClasses([
    'Phalcon\Test\UnitTestCase' => ROOT_PATH . 'test/phalcon/UnitTestCase.php',
    '<%= project.namespace %>\Test\Helper\UnitTestCase' => ROOT_PATH . 'test/helpers/UnitTestCase.php',
    '<%= project.namespace %>\Test\Helper\ModuleUnitTestCase' => ROOT_PATH . 'test/helpers/ModuleUnitTestCase.php',
    '<%= project.namespace %>\Application\Application' => ROOT_PATH . 'common/lib/application/Application.php'
])->register();

$di = new FactoryDefault();
DI::reset();

// add any needed services to the DI here

DI::setDefault($di);