<?php

namespace Ibonly\NaijaEmoji\Test;

use Guzzle\Http\Client;
use PHPUnit_Framework_TestCase;
use Guzzle\Http\Exception\ClientErrorResponseException;

class RoutesTest extends PHPUnit_Framework_TestCase
{
    public function setUp ()
    {
        $this->client = new Client('https://emojinaija.herokuapp.com');
    }

    /**
     * Test the URL
     */
    public function testURL ()
    {
        $this->request = $this->client->get('/emojis');
        $this->assertEquals("https://emojinaija.herokuapp.com/emojis", $this->request->getUrl());
    }

    /**
     * Test if the ouput of getAll is an object
     */
    public function testGetAllEmoji ()
    {
        $request = $this->client->get('/emojis');
        $response = $request->send();
        $this->assertInternalType("object", $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test get a single emoji endpoint
     */
    public function testGetSingleEmoji ()
    {
        $request = $this->client->get('/emojis');
        $response = $request->send();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test Post endpoint
     */
   public function testPOSTEmoji()
    {
        // create our http client (Guzzle)
        $data = array(
            'name' => 'skate',
            'char' => '🏄'
            'keywords' => "skate, board, ice",
            'category' => 'sport'
        );

        $this->setExpectedException("Guzzle\Http\Exception\ClientErrorResponseException");
        $request = $this->client->post('/emojis', null, json_encode($data));
        $response = $request->send();
    }

    /**
     * Test if Authorization Header is set
     */
    public function testHeaderAuthorizationNotSet ()
    {
        $request =$this->client->get('/emojis');
        $response = $request->send();
        $this->assertFalse(in_array('Host', array_keys($response->getHeaders()->toArray())
));
        $this->assertFalse($response->hasHeader("Authorization"));
    }

    /**
     * Test PUT/PATCH emoji
     */
    public function testPutPatchEmoji ()
    {
        $data = aray(
            'name' => 'Run',
        );

        $this->setExpectedException("Guzzle\Http\Exception\ClientErrorResponseException");
        $request = $this->client->put('/emojis/2', null, json_encode($data));
        $request = $this->client->patch('/emojis/2', null, json_encode($data));
        $response = $request->send();
    }
}