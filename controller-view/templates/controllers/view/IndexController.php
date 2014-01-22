<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Controllers\View;

use \<%= project.namespace %>\<%= module.namespace %>\Library\Controllers\ModuleViewController;

/**
 * Concrete implementation of <%= module.namespace %> module controller
 *
 * @RoutePrefix("/<%= module.slug %>/view")
 */
class <%= controller.name %>Controller extends ModuleViewController
{
	/**
     * @Route("/<%= controller.slug %>", paths={module="<%= module.slug %>"}, methods={"GET"}, name="<%= module.slug %>-<%= controller.slug %>-index")
     */
    public function indexAction()
    {

    }
}
