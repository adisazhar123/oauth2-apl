<?php

use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Http\Response\Cookies;
use Phalcon\Security;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Http\Request;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;

// bshaffer
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo as StoragePdo;

$di['config'] = function() use ($config) {
	return $config;
};

$di['session'] = function() {
    $session = new Session();
	$session->start();

	return $session;
};

$di['dispatcher'] = function() use ($di, $defaultModule) {

    $eventsManager = $di->getShared('eventsManager');
    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};

$di['url'] = function() use ($config, $di) {
	$url = new \Phalcon\Mvc\Url();

    $url->setBaseUri($config->url['baseUrl']);

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

$di->set('oauth_storage', function() use ($data_source_name, $username, $password) {
    $storage = new StoragePdo(array('dsn' => $data_source_name, 'username' => $username, 'password' => $password));

    return $storage;
});

$di->set('client_credentials_grant', function() {
    $storage = $this->get('oauth_storage');
    return new OAuth2\GrantType\ClientCredentials($storage);
});

$di->set('authorization_code_grant', function() {
    $storage = $this->get('oauth_storage');
    return new OAuth2\GrantType\AuthorizationCode($storage);
});

$di->set('oauth_server', function() {
    $storage = $this->get('oauth_storage');
    $oauth_server = new OAuth2Server($storage);
    
    $client_credentials_grant = $this->get('client_credentials_grant');
    $oauth_server->addGrantType($client_credentials_grant);
    
    $authorization_code_grant = $this->get('authorization_code_grant');
    $oauth_server->addGrantType($authorization_code_grant);

    return $oauth_server;
});

// $di->set('dashboard_controller',
// [
//     'className' => 'App\Oauth\Controllers\Web\DashboardController',
//     'arguments' => [
//         [
//             'type' => 'service',
//             'name' => 'oauth_server',
//         ]
//     ]
// ]);

