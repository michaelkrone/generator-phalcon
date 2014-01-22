<?php

/**
 * Simple application configuration
 */
return new \Phalcon\Config([
	'application' => [
		'baseUri' => '<%= project.rewritePath %>',
		'annotations' => ['adapter' => 'Apc'],
		'models' => [
			'metadata' => ['adapter' => 'Apc']
		]
	]
]);
