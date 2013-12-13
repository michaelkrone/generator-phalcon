<?php

namespace <%= project.namespace %>\Application;

use \Phalcon\Mvc\ModuleDefinitionInterface,
    \Phalcon\Loader,
    \Phalcon\DiInterface,
    \Phalcon\Mvc\User\Module as UserModule;

/**
 * Abstract application module base class
 */
abstract class ApplicationModule extends UserModule implements ModuleDefinitionInterface
{
    /**
     * Load the module specific routes and mount them to the router
     * before the whole module gets loaded and add routing annotated
     * controllers
     *
     * @param \Phalcon\DiInterface $di
     */
    abstract static function initRoutes(DiInterface $di);
}
