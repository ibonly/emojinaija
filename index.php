<?php

require 'vendor/autoload.php';

use Slim\Slim;
use Ibonly\NaijaEmoji\Emoji;

$app = new Slim();
$get = new Emoji();

$app->get('/emogis', function () use ($get) {
    echo $get->getAll();
});


$app->run();
