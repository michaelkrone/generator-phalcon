<?php

namespace <%= project.namespace %>\Application\Interfaces;

/**
 * Interface for objects that need to initialize customer specific configurations before loading
 */
interface CustomerConfigurationInitable {

	/**
	 * Perform any pre object init customer specific logic here,
	 * e.g. register the module specific configuration classes
	 */
    public static function initCustomerConfiguration(/* Customer $customer */);

}
