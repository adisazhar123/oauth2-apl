<?php

use Phalcon\Config;

// https://docs.phalconphp.com/3.4/en/api/Phalcon_Config

return new Config(
    [
        'mode' => 'DEVELOPMENT', //DEVELOPMENT, PRODUCTION, DEMO

        'database' => [
            'adapter' => 'Phalcon\Db\Adapter\Pdo\Sqlsrv',
            'host' => getenv('DB_HOST') || 'localhost',
            'username' => getenv('DB_USER') ,
            'password' => getenv('DB_PASS'),
            'dbname' => getenv('DB_SCHEMA'),
            'dsn' => getenv('DB_PROVIDER') . ':' . 'dbname='. getenv('DB_SCHEMA') .';host= '. getenv('DB_HOST')                
        ],   
        
        'url' => [
            'baseUrl' => 'http://dev.oauth/',
        ],
        
        'application' => [
            'libraryDir' => APP_PATH . "/lib/",
            'cacheDir' => APP_PATH . "/cache/",
        ],

        'version' => '0.1',
    ]
);

?>