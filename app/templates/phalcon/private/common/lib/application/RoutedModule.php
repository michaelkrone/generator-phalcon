<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\DiInterface;

/**
 * Abstract application module base class
 */
interface RoutedModule
{
	/**
     * Load the module specific routes and mount them to the router
     * before the whole module gets loaded and add routing annotated
     * controllers
     *
     * @param \Phalcon\DiInterface $di
     */
    static function initRoutes(DiInterface $di);
}
