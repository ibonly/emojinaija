<?php

require 'vendor/autoload.php';

use Slim\Slim;

$app = new Slim();

$app->get('/', function () {
    echo "Hello";
});

$app->run();
