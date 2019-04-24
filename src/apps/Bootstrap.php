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

		if (!$this->getDI()['db']->connect()) {
			return "Please turn on DB connection";
		}
		
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
		
		$dotenv = \Dotenv\Dotenv::create(__DIR__ . '/../');
		$dotenv->load();

		$di = new FactoryDefault();
		$config = require APP_PATH . '/config/config.php';
		$modules = $this->modules;		

		include_once APP_PATH . '/config/constants.php';
		include_once APP_PATH . '/config/loader.php';
		include_once APP_PATH . '/config/services.php';
		include_once APP_PATH . '/config/routing.php';
		

		$this->setDI($di);
	}
}

?>