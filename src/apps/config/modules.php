<?php

return array(
 
    'oauth' => [
        'namespace' => 'App\Oauth',
        'webControllerNamespace' => 'App\Oauth\Controllers\Web',
        'apiControllerNamespace' => 'App\Oauth\Controllers\Api',
        'className' => 'App\Oauth\Module',
        'path' => APP_PATH . '/modules/oauth/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'dashboard',
        'defaultAction' => 'index'
    ],
    'client' => [
        'namespace' => 'App\Client',
        'webControllerNamespace' => 'App\Client\Controllers\Web',
        'apiControllerNamespace' => 'App\Client\Controllers\Api',
        'className' => 'App\Client\Module',
        'path' => APP_PATH . '/modules/client/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'dashboard',
        'defaultAction' => 'index'
    ],
);

?>