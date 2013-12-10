<?php

/**
 * Create a Router instance and define global application routes.
 * Module specific routes are defined inside the ModuleRoutes classes.
 */
use \Phalcon\Mvc\Router;

$router = new Router();
$router->removeExtraSlashes(true);
$router->setDefaultController('index');
$router->setDefaultAction('index');

/**
 * Add global matching route for default module
 */
$router->add('/', [
	'module' => '<%= module.slug %>',
	'namespace' => '<%= project.namespace %>\<%= module.namespace %>\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
])->setName('default-route');

/**
 * Add default not found route
 */
$router->notFound([
    'controller' => 'index',
    'action' => 'route404'
]);

return $router;
