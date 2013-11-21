<?php

/**
 * Create a Router instance and define global application routes.
 * Note that module specific routes are defined inside the ModuleRoutes classes.
 */
use Phalcon\Mvc\Router;

$router = new Router();

$router->removeExtraSlashes(true);
$router->setDefaultModule('<%= module.slug %>');
$router->setDefaultNamespace('<%= project.namespace %>\<%= module.namespace %>\Controllers\\');
$router->setDefaultController('index');
$router->setDefaultAction('index');

/**
 * Add global matching route for default module
 
$router->add('/(.*)', array(
	'module' => '<%= module.slug %>',
	'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\\'
))->setName('default-route');
*/

return $router;
