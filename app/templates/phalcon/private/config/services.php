<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Url as UrlResolver,
	Phalcon\DI\FactoryDefault,
	Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The application wide configuration
 */
$config = include __DIR__ . '/config.php';

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Register the config as shared service
 */
$di->setShared('config', $config);

/**
 * Registering a router
 */
$di['router'] = function () use ($application)
{
	require __DIR__ . '/routes.php';
	return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () use ($config)
{
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);
	return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function ()
{
	$session = new SessionAdapter();
	$session->start();
	return $session;
};

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di['modelsMetadata'] = function () use ($config)
{
	if (isset($config->models->metadata)) {
		$metaDataConfig = $config->models->metadata;
		$metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
		return new $metadataAdapter();
	} else {
		return new \Phalcon\Mvc\Model\Metadata\Memory();
	}
};
