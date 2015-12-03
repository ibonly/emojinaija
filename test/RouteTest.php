<?php

namespace Ibonly\NaijaEmoji\Test;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Ibonly\NaijaEmoji\Emoji;
use Ibonly\NaijaEmoji\GetEnv;
use PHPUnit_Framework_TestCase;
use GuzzleHttp\Exception\ClientException;

class RoutesTest extends PHPUnit_Framework_TestCase
{
    protected $url;
    protected $name;
    protected $token;
    protected $client;

    public function __construct ()
    {
        $values = new GetEnv();

        $this->token = $values->getTestToken();
        $this->url = $values->getAuthUrl();
        $this->emojiName = 'TestEmojiName'.time();
    }

    public function setUp ()
    {
        $this->client = new Client();
        $this->emoji = new Emoji;
    }

    /**
     * testInvalidEndpoint
     */
    public function testInvalidEndpoint ()
    {
        $this->setExpectedException("GuzzleHttp\Exception\ClientException");

        $request = $this->client->request('GET', $this->url.'/emogis');
    }

    /**
     * Test if the ouput of getAll is an object
     */
    public function testGetAllEmoji ()
    {
        $data =  $this->emoji->where(['name' => $this->emojiName])->toJson();

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
            'name' => $this->emojiName,
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
        $data = array(
            'name' => $this->emojiName,
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
            'category' => 'Fruit Flavour'
        );
        $request = $this->client->request('PUT', $this->url.'/emojis/91',[ 'headers' => ['Authorization'=> $this->token],'form_params' => $data ]);

        $this->assertInternalType('object' , $request);
        $this->assertEquals('200', $request->getStatusCode());
    }

    /**
     * Test DELETE an emoji
     */
    public function testDeleteEmoji ()
    {
        $request = $this->client->request('DELETE', $this->url.'/emojis/91', [ 'headers' => ['Authorization'=> $this->token]]);

        $this->assertInternalType('object' , $request);
        $this->assertEquals('200', $request->getStatusCode());
    }
}
