<?php

require 'vendor/autoload.php';

use Slim\Slim;
use Ibonly\NaijaEmoji\UserController;
use Ibonly\NaijaEmoji\EmojiController;
date_default_timezone_set('Africa/Lagos');

$app = new Slim();
$user = new UserController();
$emoji = new EmojiController();

/**
 * Emoji Route
 */
$app->get('/emojis', function () use ($emoji, $app) {
    echo $emoji->getAllEmoji($app);
});

$app->get('/emojis/:id', function ($id) use ($emoji, $app) {
    echo $emoji->findEmoji($id, $app);
});

$app->post('/emojis', function()use ($emoji, $app) {
    echo $emoji->insertEmoji($app);
});

$app->patch('/emojis/:id', function($id) use ($emoji, $app) {
    echo $emoji->updateEmoji($id, $app);
});

$app->put('/emojis/:id', function($id) use ($emoji, $app) {
    echo $emoji->updateEmoji($id, $app);
});

$app->delete('/emojis/:id', function($id) use ($emoji) {
    echo $emoji->deleteEmoji($id);
});

/**
 * User Route
 */
$app->post('/register', function () use ($user, $app) {
    echo $user->createUser($app);
});

$app->post('/auth/login', function () use ($user, $app) {
    echo $user->login($app);
});
$app->get('/auth/logout', function () use ($user, $app) {
    echo $user->logout($app);
});

$app->run();