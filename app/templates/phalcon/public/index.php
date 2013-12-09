<?php

use Phalcon\DI\FactoryDefault;

/**
 * We're not registering the root library to instantiate the Application class,
 * just include it for performance reasons (can be cached by APC, no object creation etc.)
 */
require __DIR__ . '/../private/common/lib/application/Application.php';
 
try {
	$application = new <%= project.namespace %>\Application\Application(new FactoryDefault());
	$application->main();
} catch (\Phalcon\Exception $e) {
	echo 'A Phalcon\Exception occurred: ', $e->getMessage(), $e->getTraceAsString();
} catch (\PDOException $e) {
	echo 'A PDOException occurred: ', $e->getMessage(), $e->getTraceAsString();
} catch (\Exception $e) {
	echo 'An Exception occurred: ', $e->getMessage(), $e->getTraceAsString();
}
