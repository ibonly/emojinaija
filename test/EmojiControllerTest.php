<?php

namespace Ibonly\NaijaEmoji\Test;

use Mockery;
use Slim\Slim;
use PHPUnit_Framework_TestCase;
use Ibonly\NaijaEmoji\EmojiController;

class EmojiControllerTest extends PHPUnit_Framework_TestCase
{

    protected $app;

    public function setUp()
    {
        $this->mockedSlim = Mockery::mock('Slim');
        $this->emoji = new EmojiController();
    }

    public function request($method, $path, $options = array())
    {
        ob_start();
        Environment::mock(array_merge(array(
            'PATH_INFO'         => $path,
            'SERVER_NAME'       => 'slim-test.dev',
            'REQUEST_METHOD'    => $method,
        ), $options));
        $this->app            = new Slim();
        $this->request = $this->app->request();
        return ob_get_clean();
    }

    /**
     * @covers class::()
     */
    public function testGetAllEmoji()
    {
        $this->assertEquals(1, $this->emoji->getAllEmoji($this->mockedSlim));
    }
}
