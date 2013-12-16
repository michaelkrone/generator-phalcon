<?php

namespace <%= project.namespace %>\<%= module.namespace %>\Test;

use <%= project.namespace %>\<%= module.namespace %>\Test\Helper\ModuleUnitTestCase;

/**
 * Test class for Application class
 * @covers <%= project.namespace %>\<%= module.namespace %>\Module
 */
class ModuleTest extends ModuleUnitTestCase {

	public function testModule()
	{
	    $this->assertEquals(0, 0);
	}
}
