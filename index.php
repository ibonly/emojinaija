<?php

require 'vendor/autoload.php';

// use Slim\Slim;
use Ibonly\NaijaEmoji\Emoji;

// $app = new Slim();

// // $app->get('/hello/:name', function ($name) {
// //     echo "Hello, $name";
// // });

$emoji = new Emoji();

echo $emoji->getAll();

// $app->run();