<?php

use Phalcon\Mvc\View;
use Phalcon\Security;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Http\Response\Cookies;
use Phalcon\Flash\Direct as FlashDirect;

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

