<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Server.php';

use app\extension\guzzlehttp\guzzle\src\Tests\Server;

register_shutdown_function(function () {
    if (Server::$started) {
        Server::stop();
    }
});
