<?php

use Phalcon\Mvc\Application;

error_reporting(E_ALL);

try {

	
	/**
	 * Get new application instance
	 */
	$application = new Application();

	/**
	 * Include services
	 */
	require __DIR__ . '/../private/config/services.php';


	/**
	 * Assign the DI
	 */
	$application->setDI($di);

	/**
	 * Include modules
	 */
	require __DIR__ . '/../private/config/modules.php';

	/**
	 * Handle the request
	 */
	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo 'Phalcon\Exception: ', $e->getMessage(), $e->getTraceAsString();
} catch (PDOException $e) {
	echo 'PDOException: ', $e->getMessage(), $e->getTraceAsString();
}