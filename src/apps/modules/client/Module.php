<?php

namespace App\Client;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ModuleDefinitionInterface;

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
            'App\Client\Models' => __DIR__ . '/models',
            'App\Client\Services' => __DIR__ . '/services',
            'App\Client\Contracts' => __DIR__ . '/contracts',
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

        $di->set('token_service', function() {
            return new \App\Client\Services\RequestTokenService();
        });

        // $di->set('resource_service', function() {
        //     return new \App\Client\Services\ResourceService();
        // });
        

        // $di->set('guzzle_http', function() {
        //     return new \App\Client\Services\GuzzleHttpRequest();
        // });

        $di->set('guzzle_client', function() {
            return new \GuzzleHttp\Client();
        });
    

        $di->set('guzzle_http', [
            'className' => 'App\Client\Services\GuzzleHttpRequest',
            'arguments' => [
                [
                    'type' => 'service',
                    'name' => 'guzzle_client'
                ]
            ]
        ]);

        $di->set('curl_http', function() {
            return new \App\Client\Services\CurlHttpRequest();
        });

        $di->set('resource_service', [
            'className' => 'App\Client\Services\ResourceService',
            'arguments' => [
                [
                    'type' => 'service',
                    'name' => 'curl_http'
                ]
            ]
        ]);
    }
}
?>