<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Library\Controllers;

use <%= project.namespace %>\Application\Controllers\ApplicationApiController;

/**
 * Base class of <%= module.namespace %> module API controller
 */
class ModuleApiController extends ApplicationApiController
{
	public function beforeExecuteRoute($dispatcher)
	{
		$this->response->setContentType('application/json');
	}
}