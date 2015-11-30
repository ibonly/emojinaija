<?php

namespace Ibonly\NaijaEmoji\Test;

use Guzzle\Http\Client;
use PHPUnit_Framework_TestCase;
use Guzzle\Http\Exception\ClientErrorResponseException;

class RoutesTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Client('https://emojinaija.herokuapp.com');
        $this->request = $this->client->get('/emojis');
        $this->response = $this->request->send();
    }

    /**
     * Test the URL
     */
    public function testURL()
    {
        $this->assertEquals("https://emojinaija.herokuapp.com/emojis", $this->request->getUrl());
    }

    /**
     * Test if the ouput of getAll is an object
     */
    public function testGetAllEmoji()
    {
        $this->assertInternalType("object", $this->response->getBody());
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    /**
     * Test get a single emoji endpoint
     */
    public function testGetSingleEmoji()
    {
        $endpoint = $this->client->get('emogis/5');
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    /**
     * Test Post endpoint
     */
   public function testPOSTEmoji()
    {
        // create our http client (Guzzle)
        $data = array(
            'name' => 'Run',
            'char' => '🏃',
            'keywords' => "Run, Ere",
            'category' => 'force'
        );

        $this->setExpectedException("Guzzle\Http\Exception\ClientErrorResponseException");
        $request = $this->client->post('/emojis', null, json_encode($data));
        $response = $request->send();
    }

    /**
     * Test if Authorization Header is set
     */
    public function testHeaderAuthorizationNotSet()
    {
        $this->assertFalse(in_array('Host', array_keys($this->response->getHeaders()->toArray())
));
        $this->assertFalse($this->response->hasHeader("Authorization"));
    }

    /**
     * Test PUT/PATCH emoji
     */
    public function testPutPatchEmoji()
    {
        $data = array(
            'name' => 'Run',
        );

        $this->setExpectedException("Guzzle\Http\Exception\ClientErrorResponseException");
        $request = $this->client->put('/emojis/2', null, json_encode($data));
        $request = $this->client->patch('/emojis/2', null, json_encode($data));
        $response = $request->send();
    }
}