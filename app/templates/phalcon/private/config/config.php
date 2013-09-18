<?php

return new \Phalcon\Config(array(
	'application' => array(
		'baseUri' => '<%= project.rewritePath %>',
		'models' => array(
			'metadata' => array('adapter' => 'Apc')
		)
	)
));
