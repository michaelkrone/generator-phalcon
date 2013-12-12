<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Controllers\API;

use \<%= project.namespace %>\<%= module.namespace %>\Controllers\ModuleApiController;

/**
 * Concrete implementation of <%= module.namespace %> module controller
 *
 * @RoutePrefix("/<%= module.slug %>")
 */
class IndexController extends ModuleApiController
{
	/**
     * @Route("/", methods={"GET"}, paths={module="<%= module.slug %>"}, name="<%= module.slug %>-default")
     */
    public function indexAction()
    {

    }
}
