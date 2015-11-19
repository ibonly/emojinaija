<?php

require 'vendor/autoload.php';

use Slim\Slim;
use Ibonly\NaijaEmoji\Emoji;

$app = new Slim();
$get = new Emoji();

$app->get('/', function () {
    echo "Hello";
});
echo $get->getAll();

$app->run();
