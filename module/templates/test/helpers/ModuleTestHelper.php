<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__ . '/../../../../');
define('PATH_LIBRARY', __DIR__ . '/common/lib/application/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

/**
 * Use the application autoloader to autoload the required
 * bootstrap and test helper classes
 */
$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Phalcon\Test' => ROOT_PATH . 'test/phalcon/',
	'<%= project.namespace %>\Test\Helper' => ROOT_PATH . 'test/helpers/',
	'<%= project.namespace %>\Application' => ROOT_PATH . 'private/common/lib/application/',
	'<%= project.namespace %>\Application\Controllers' => ROOT_PATH . 'private/common/lib/application/controllers/',
	'<%= project.namespace %>\<%= module.namespace %>' => ROOT_PATH . 'private/modules/<%= module.slug %>/',
	'<%= project.namespace %>\<%= module.namespace %>\Controllers' => ROOT_PATH . 'private/modules/<%= module.slug %>/controllers/',
	'<%= project.namespace %>\<%= module.namespace %>\Controllers\API' => ROOT_PATH . 'private/modules/<%= module.slug %>/controllers/api/',
	'<%= project.namespace %>\<%= module.namespace %>\Controllers\View' => ROOT_PATH . 'private/modules/<%= module.slug %>/controllers/view/',
	'<%= project.namespace %>\<%= module.namespace %>\Models' => ROOT_PATH . 'private/modules/<%= module.slug %>/models/',
	'<%= project.namespace %>\<%= module.namespace %>\Library' => ROOT_PATH . 'private/modules/<%= module.slug %>/lib/',
	'<%= project.namespace %>\<%= module.namespace %>\Library\Models' => ROOT_PATH . 'private/modules/<%= module.slug %>/lib/models/',
	'<%= project.namespace %>\<%= module.namespace %>\Library\Controllers' => ROOT_PATH . 'private/modules/<%= module.slug %>/lib/Controllers/',
    '<%= project.namespace %>\<%= module.namespace %>\Test\Helper' => ROOT_PATH . 'test/modules/<%= module.slug %>/helpers/',

])->register();

$di = new FactoryDefault();
DI::reset();

// add any needed services to the DI here

DI::setDefault($di);
