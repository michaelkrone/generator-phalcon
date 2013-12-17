<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Test;

use <%= project.namespace %>\<%= module.namespace %>\Test\Helper\ModuleUnitTestCase;

/**
 * Test class for Application class
 * @covers <%= project.namespace %>\<%= module.namespace %>\Controllers\API\<%= controller.fullName %>
 */
class <%= controller.name %>ControllerTest extends ModuleUnitTestCase {

	public function testController()
	{
	    $this->assertEquals(0, 0);
	}
}
