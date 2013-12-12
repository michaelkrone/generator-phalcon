<?php

/**
 * Simple application configuration
 */
return new \Phalcon\Config([
	
	'database' => [
		'adapter' => 'Mysql',
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname' => 'test',
		'persistent' => true,
		'charset' => 'utf8'
	],

	'application' => [
		'baseUri' => '<%= project.rewritePath %>',
		'models' => [
			'metadata' => ['adapter' => 'Apc']
		]
	]
]);
