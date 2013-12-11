<?php

namespace <%= project.namespace %>\Application\Interfaces;

use \Phalcon\Mvc\ModuleDefinitionInterface,
	\Phalcon\Mvc\User\Module as UserModule;

abstract class ApplicationModule
	extends UserModule
	implements ModuleDefinitionInterface,
		ConfigurationInitable,
		CustomerConfigurationInitable
{

}
