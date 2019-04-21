<?php

use Phalcon\Config;

// https://docs.phalconphp.com/3.4/en/api/Phalcon_Config

return new Config(
    [
        'client_id' => getenv('CLIENT_ID'),
        'client_secret' => getenv('CLIENT_SECRET')
    ]
);

?>