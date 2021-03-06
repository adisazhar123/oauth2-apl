<?php

use Phalcon\Config;

// https://docs.phalconphp.com/3.4/en/api/Phalcon_Config

return new Config(
    [
        'mode' => 'DEVELOPMENT', //DEVELOPMENT, PRODUCTION, DEMO

        'database' => [
            'adapter' => 'Phalcon\Db\Adapter\Pdo\Sqlsrv',
            'host' => 'localhost',
            'username' => 'user',
            'password' => 'pass',
            'dbname' => 'dbname'
        ],   
        
        'url' => [
            'baseUrl' => 'http://oidc.local/',
        ],
        
        'application' => [
            'libraryDir' => APP_PATH . "/lib/",
            'cacheDir' => APP_PATH . "/cache/",
        ],

        'version' => '0.1',
    ]
);

?>