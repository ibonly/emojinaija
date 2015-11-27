<?php
require 'vendor/autoload.php';

use Guzzle\Http\Client;

// Create a client and provide a base URL
$client = new Client('https://emojinaija.herokuapp.com');

$request = $client->get('/emojis');
// $request->setAuth('user', 'pass');
echo $request->getUrl()."<br />";
// >>> https://api.github.com/user

// You must send a request in order for the transfer to occur
$response = $request->send();

echo $response->getBody()."<br />";
// >>> {"type":"User", ...

echo $response->getHeader('Content-Length')."<br />";
// >>> 792

$data = $response->json();
echo $data['name'];
// >>> User