<?php

use Phalcon\Mvc\Application;

error_reporting(E_ALL);

try {

	/**
	 * Include services
	 */
	require __DIR__ . '/../private/config/services.php';

	/**
	 * Handle the request
	 */
	$application = new Application();

	/**
	 * Assign the DI
	 */
	$application->setDI($di);

	/**
	 * Include modules
	 */
	require __DIR__ . '/../private/config/modules.php';

	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}