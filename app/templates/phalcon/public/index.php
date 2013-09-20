<?php

/**
 * We're not registering the root library to instantiate the Application class,
 * just include it for performance reasons (can be cached by APC, no object creation etc.)
 */
include __DIR__ . '/../private/common/lib/application/Application.php';
 
try {
	$application = new <%= project.namespace %>\Application\Application();
	$application->main();
} catch (\Phalcon\Exception $e) {
	echo 'Phalcon\Exception: ', $e->getMessage(), $e->getTraceAsString();
} catch (\PDOException $e) {
	echo 'PDOException: ', $e->getMessage(), $e->getTraceAsString();
} catch (\Exception $e) {
	echo 'Exception: ', $e->getMessage(), $e->getTraceAsString();
}
