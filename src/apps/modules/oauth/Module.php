<?php

namespace App\Oauth;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ModuleDefinitionInterface;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo as StoragePdo;
class Module implements ModuleDefinitionInterface
{   
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Oauth\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Oauth\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Oauth\Models' => __DIR__ . '/models',
            'App\Oauth\Contracts' => __DIR__ . '/contracts',
            'App\Oauth\Services' => __DIR__ . '/services',
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

        // $di->setShared('oauth_storage', function() use ($data_source_name, $username, $password) {
        //     $storage = new StoragePdo(array('dsn' => $data_source_name, 'username' => $username, 'password' => $password));
        
        //     return $storage;
        // });
        
        // $di->setShared('client_credentials_grant', function() {
        //     $storage = $this->get('oauth_storage');
        //     return new OAuth2\GrantType\ClientCredentials($storage);
        // });
        
        // $di->setShared('authorization_code_grant', function() {
        //     $storage = $this->get('oauth_storage');
        //     return new OAuth2\GrantType\AuthorizationCode($storage);
        // });

        // $di->setShared('bshaffer_oauth_instance', function() use ($data_source_name, $username, $password) {
        //     $storage = $this->get('oauth_storage');
        //     $oauth_server = new OAuth2Server($storage);
            
        //     $client_credentials_grant = $this->get('client_credentials_grant');
        //     $oauth_server->addGrantType($client_credentials_grant);
            
        //     $authorization_code_grant = $this->get('authorization_code_grant');
        //     $oauth_server->addGrantType($authorization_code_grant);
        
        //     return $oauth_server;
        // });        

        // $di->set('oauth_server', [
        //     'className' => 'App\Oauth\Services\BshafferOauthServer',
        //     'arguments' => [
        //         [
        //             'type' => 'service',
        //             'name' => 'bshaffer_oauth_instance'
        //         ]
        //     ]
        // ]);

        // $di->set('bshaffer_oauth_response', function() {
        //     return new \OAuth2\Response();
        // });


        // $di->set('bshaffer_oauth_response', [
        //     'className' => 'App\Oauth\Services\BshafferOauthResponse',
        //     'arguments' => [
        //         [
        //             'type' => 'service',
        //             'name' => 'bshaffer_oauth_response'
        //         ]
        //     ]
        // ]);

        // $di->set('bshaffer_oauth_request', 'App\Oauth\Services\BshafferOauthRequest');


        // $di->set('authorize_service', [
        //     'className' => 'App\Oauth\Services\AuthorizeService',
        //     'arguments' => [
        //         [
        //             'type' => 'service',
        //             'name' => 'oauth_server'
        //         ],
        //         [
        //             'type' => 'service',
        //             'name' => 'bshaffer_oauth_response'
        //         ],
        //         [
        //             'type' => 'service',
        //             'name' => 'bshaffer_oauth_request'
        //         ]
        //     ]
        // ]);

        

    }
}
?>