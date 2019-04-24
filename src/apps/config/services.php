<?php

use Phalcon\Mvc\View;
use Phalcon\Security;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Http\Response\Cookies;
use Phalcon\Flash\Direct as FlashDirect;

// bshaffer
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo as StoragePdo;

use Phalcon\Flash\Session as FlashSession;
use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Session\Adapter\Files as Session;


$di['response'] = function() {
    return new Response();
};

$di['config'] = function() use ($config) {
	return $config;
};

// Make a connection
$di->setShared('db', function() {    
    return new Mysql(
        [
            "host"     => getenv('DB_HOST'),
            "username" => getenv('DB_USER'),
            "password" => getenv('DB_password'),
            "dbname"   => getenv('DB_SCHEMA'),
            "port"     => getenv('DB_PORT'),
        ]
    );
});

$di['session'] = function() {
    $session = new Session();
	$session->start();

	return $session;
};


$di->set('preflight', function() {
    return new \App\Oauth\Listeners\PreFlightListener();
}, true);

$di['dispatcher'] = function() use ($di, $defaultModule) {

    $eventsManager = $di->getShared('eventsManager');

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};

$di['url'] = function() use ($config, $di) {
	$url = new \Phalcon\Mvc\Url();

    // $url->setBaseUri($config->url['baseUrl']);

	return $url;
};

$di['voltService'] = function($view, $di) use ($config) {
    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
    if (!is_dir($config->application->cacheDir)) {
        mkdir($config->application->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(array(
        "compiledPath" => $config->application->cacheDir,
        "compiledExtension" => ".compiled",
        "compileAlways" => $compileAlways
    ));
    return $volt;
};

$di->set(
    'security',
    function () {
        $security = new Security();
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

$di->set(
    'flash',
    function () {
        $flash = new FlashDirect(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        return $flash;
    }
);

$di->set(
    'flashSession',
    function () {
        $flash = new FlashSession(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        $flash->setAutoescape(false);
        
        return $flash;
    }
);

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();
        $cookies->useEncryption(false);
        
        return $cookies;
    }
);

$di->set('request', new Request());

$di->setShared('oauth_storage', function() use ($data_source_name, $username, $password) {
    $storage = new StoragePdo(array('dsn' => $data_source_name, 'username' => $username, 'password' => $password));

    return $storage;
});

$di->setShared('client_credentials_grant', function() {
    $storage = $this->get('oauth_storage');
    return new OAuth2\GrantType\ClientCredentials($storage);
});

$di->setShared('authorization_code_grant', function() {
    $storage = $this->get('oauth_storage');
    return new OAuth2\GrantType\AuthorizationCode($storage);
});

$di->setShared('bshaffer_oauth_instance', function() use ($data_source_name, $username, $password) {
    $storage = $this->get('oauth_storage');
    $oauth_server = new OAuth2Server($storage);
    
    $client_credentials_grant = $this->get('client_credentials_grant');
    $oauth_server->addGrantType($client_credentials_grant);
    
    $authorization_code_grant = $this->get('authorization_code_grant');
    $oauth_server->addGrantType($authorization_code_grant);

    return $oauth_server;
});        

$di->setShared('oauth_server', [
    'className' => 'App\Oauth\Services\BshafferOauthServer',
    'arguments' => [
        [
            'type' => 'service',
            'name' => 'bshaffer_oauth_instance'
        ]
    ]
]);

$di->set('bshaffer_oauth_response_instance', function() {
    return new \OAuth2\Response();
});


$di->set('bshaffer_oauth_response', [
    'className' => 'App\Oauth\Services\BshafferOauthResponse',
    'arguments' => [
        [
            'type' => 'service',
            'name' => 'bshaffer_oauth_response_instance'
        ]
    ]
]);

$di->set('bshaffer_oauth_request', function() {
    return new App\Oauth\Services\BshafferOauthRequest();
});


$di->set('authorize_service', [
    'className' => 'App\Oauth\Services\AuthorizeService',
    'arguments' => [
        [
            'type' => 'service',
            'name' => 'oauth_server'
        ],
        [
            'type' => 'service',
            'name' => 'bshaffer_oauth_response'
        ],
        [
            'type' => 'service',
            'name' => 'bshaffer_oauth_request'
        ]
    ]
]);

$di->set('resource_service_server', [
    'className' => 'App\Oauth\Services\ResourceService',
    'arguments' => [
        [
            'type' => 'service',
            'name' => 'oauth_server'
        ]
    ]
]);

$di->set('token_service', [
    'className' => 'App\Oauth\Services\TokenService',
    'arguments' => [
        [
            'type' => 'service',
            'name' => 'oauth_server'
        ]
    ]
]);

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

// $di->setShared('oauth_server', function() use ($data_source_name, $username, $password) {
//     $storage = $this->get('oauth_storage');
//     $oauth_server = new OAuth2Server($storage);
    
//     $client_credentials_grant = $this->get('client_credentials_grant');
//     $oauth_server->addGrantType($client_credentials_grant);
    
//     $authorization_code_grant = $this->get('authorization_code_grant');
//     $oauth_server->addGrantType($authorization_code_grant);

//     return $oauth_server;
// });

