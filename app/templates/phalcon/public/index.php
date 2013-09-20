<?php

/**
 * We're a registering the root library to instantiate the Application class
 */
 $loader = new \Phalcon\Loader();
 $loader->registerNamespaces(
 	['<%= project.namespace %>\Application' => __DIR__ . '/../private/common/lib/application/']
 )->register();
 
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