<?php

namespace App\Client;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class Module implements ModuleDefinitionInterface
{   
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Client\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Client\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Client\Models' => __DIR__ . '/models'
        ]);

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di = null)
    {
        // Registering the view component
        $di['view'] = function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines(
                [
                    ".volt" => "voltService",
                ]
            );

            return $view;
        };

        $di->set('oauth_client', function() {
            $config = INCLUDE dirname(__FILE__) . '/config/config.php';
            return $config;
        });
    }
}
?>