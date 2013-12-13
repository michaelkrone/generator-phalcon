<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Controllers\API;

use \<%= project.namespace %>\<%= module.namespace %>\Controllers\ModuleApiController;

/**
 * Concrete implementation of <%= module.namespace %> module controller
 *
 * @RoutePrefix("/<%= module.slug %>/api")
 */
class <%= controller.name %>Controller extends ModuleApiController
{
	/**
     * @Route("/<%= controller.slug %>", methods={"GET"}, name="<%= module.slug %>-<%= controller.slug %>")
     */
    public function indexAction()
    {

    }
}
