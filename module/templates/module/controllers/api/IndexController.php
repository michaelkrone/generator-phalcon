<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Controllers\API;

use \<%= project.namespace %>\<%= module.namespace %>\Controllers\ModuleApiController;

/**
 * Concrete implementation of <%= module.namespace %> module controller
 *
 * @RoutePrefix("/<%= module.slug %>/api")
 */
class IndexController extends ModuleApiController
{
	/**
     * @Route("/test", methods={"GET"}, name="<%= module.slug %>-default")
     */
    public function indexAction()
    {

    }
}
