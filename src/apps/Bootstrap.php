<?php

use Phalcon\Mvc\Application;
use Phalcon\Debug;
use Phalcon\DI\FactoryDefault;

class Bootstrap extends Application
{
	private $modules;
	private $defaultModule;

	public function __construct($defaultModule)
	{
		$this->modules = require APP_PATH . '/config/modules.php';
		$this->defaultModule= $defaultModule;
	}

	public function init()
	{		
		$this->_registerServices();

		$config = $this->getDI()['config'];

		if ($config->mode == 'DEVELOPMENT') {
			$debug = new Debug();
			$debug->listen();
		}
		
		/**
		 * Load modules
		 */
		$this->registerModules($this->modules);

		echo $this->handle()->getContent();
	}

	private function _registerServices()
	{
		$defaultModule = $this->defaultModule;

		$di = new FactoryDefault();
		$config = require APP_PATH . '/config/config.php';
		$modules = $this->modules;

		$data_source_name = 'mysql:dbname=bshaffer;host=localhost';
		$username = 'adis';
		$password = '';

		include_once APP_PATH . '/config/constants.php';
		include_once APP_PATH . '/config/loader.php';
		include_once APP_PATH . '/config/services.php';
		include_once APP_PATH . '/config/routing.php';

		$this->setDI($di);
	}
}

?>