<?php

/**
 * Simple application configuration
 */
return new \Phalcon\Config(array(
	
	'database' => array(
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname'     => 'test',
		'persistent' => true,
		'charset' => 'utf8'
	),

	'application' => array(
		'baseUri' => '<%= project.rewritePath %>',
		'models' => array(
			'metadata' => array('adapter' => 'Apc')
		)
	)
));
