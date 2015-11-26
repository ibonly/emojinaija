<?php

namespace Ibonly\NaijaEmoji\Test;

use Slim\Slim;
use Slim\Environment;
use PHPUnit_Framework_TestCase;
use Ibonly\NaijaEmoji\EmojiController;

class EmojiControllerTest extends PHPUnit_Framework_TestCase
{
    protected $app;
    protected $emoji;

    public function setUp()
    {
        Environment::mock(array_merge(array(
            'PATH_INFO'         => $path,
            'SERVER_NAME'       => 'slim-test.dev',
            'REQUEST_METHOD'    => $method,
        ), $options));
        $this->app = new Slim();
        $this->emoji = new EmojiController();
    }

    public function tearDown()
    {
        // your code here
    }

    /**
     * @covers class::()
     */
    public function testGetAllEmojis()
    {
        $this->assertEquals(1, $this->emoji->getAllEmoji($this->app));
    }
}
