<?php

namespace Ibonly\NaijaEmoji\Test;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Ibonly\NaijaEmoji\Emoji;
use PHPUnit_Framework_TestCase;
use Ibonly\NaijaEmoji\AuthController;
use GuzzleHttp\Exception\ClientException;

class RoutesTest extends PHPUnit_Framework_TestCase
{
    protected $url;
    protected $token;
    protected $client;

    public function __construct ()
    {
        $this->emoji = new Emoji();
        $auth = new AuthController();

        $this->token = $auth->getTestToken();
        $this->url = $auth->getAuthUrl();
    }

    public function setUp ()
    {
        $this->client = new Client();
    }

    /**
     * testInvalidEndpoint
     */
    public function testInvalidEndpoint()
    {
        $this->setExpectedException("GuzzleHttp\Exception\ClientException");

        $request = $this->client->request('GET', $this->url.'/emogis');
    }

    /**
     * Test if the ouput of getAll is an object
     */
    public function testGetAllEmoji ()
    {
        $request = $this->client->request('GET', $this->url.'/emojis');

        $this->assertInternalType("object", $request->getBody());
        $this->assertEquals(200, $request->getStatusCode());
    }

    /**
     * Test get a single emoji endpoint
     */
    public function testGetSingleEmoji ()
    {
        $request = $this->client->request('GET', $this->url.'/emojis/3');

        $this->assertInternalType("object", $request->getBody());
        $this->assertEquals(200, $request->getStatusCode());
    }

    /**
     * Test Post endpoint
     */
    public function testPOSTEmoji()
    {
        $data = array(
            'name' => 'TestEmojiName',
            'char' => '🎃',
            'keywords' => "apple, friut, mac",
            'category' => 'fruit'
        );
        $request = $this->client->request('POST', $this->url.'/emojis',[ 'headers' => ['Authorization'=> $this->token],'form_params' => $data ]);

        $this->assertInternalType('object' , $request);
        $this->assertEquals('200', $request->getStatusCode());
    }

    /**
     * Test if Authorization Header is set
     */
    public function testPostIfAuthorizationNotSet ()
    {
        $id = $this->emoji->where(['name' => 'TestEmojiName'])->getData('id');
        $data = array(
            'name' => 'TestEmojiName',
            'char' => '🎃',
            'keywords' => "apple, friut, mac",
            'category' => 'fruit'
        );

        $this->setExpectedException("GuzzleHttp\Exception\ClientException");

        $request = $this->client->request('POST', $this->url.'/emojis', ['form_params' => $data]);

    }

    /**
     * Test PUT/PATCH emoji
     */
    public function testPutPatchEmoji ()
    {
        $data = array(
            'name' => 'TestName'
        );
        $request = $this->client->request('PUT', $this->url.'/emojis/57',[ 'headers' => ['Authorization'=> $this->token],'form_params' => $data ]);

        $this->assertInternalType('object' , $request);
        $this->assertEquals('200', $request->getStatusCode());
    }

    /**
     * Test DELETE an emoji
     */
    public function testDeleteEmoji ()
    {
        $request = $this->client->request('DELETE', $this->url.'/emojis/57', [ 'headers' => ['Authorization'=> $this->token]]);

        $this->assertInternalType('object' , $request);
        $this->assertEquals('200', $request->getStatusCode());
    }
}
