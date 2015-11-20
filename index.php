<?php

require 'vendor/autoload.php';

use Slim\Slim;
use Ibonly\NaijaEmoji\Emoji;

$app = new Slim();
$get = new Emoji();

$app->get('/emojis', function () use ($get) {
    echo $get->getAll();
});

$app->get('/emojis/:id', function ($id) use ($get) {
    echo $get->where('id', $id);
});

$app->post('/emojis/:name', function($name){

    $save = new Emoji();
    $save->id = NULL;
    $save->name = $name;
    echo $save->save();
});

$app->patch('/emojis/:id/:name', function($id, $name){

    $find = Emoji::find($id);
    $find->name = $name;
    echo $find->update();

});

$app->run();