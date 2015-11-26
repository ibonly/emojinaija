<?php

namespace Ibonly\NaijaEmoji\Test;

use Mockery;
use Slim\Slim;
use Slim\Environment;
use PHPUnit_Framework_TestCase;

class RouteTest extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function request($method, $path, $options = array())
    {
        ob_start();
        Environment::mock(array_merge(array(
            'PATH_INFO'         => $path,
            'SERVER_NAME'       => 'slim-test.dev',
            'REQUEST_METHOD'    => $method,
        ), $options));
        $this->app            = new Slim();
        $this->response = $this->app->response();
        return ob_get_clean();
    }

    /**
     * @covers class::()
     */
    public function get( $path, $options = [] )
    {
        $this->request('GET', $path, $options);
    }

    public function post( $path, $options = [] )
    {
        $this->request('POST', $path, $options);
    }
    public function patch( $path, $options = [] )
    {
        $this->request('PATCH', $path, $options);
    }
    public function put( $path, $options = [] )
    {
        $this->request('PUT', $path, $options);
    }
    public function delete( $path, $options = [] )
    {
        $this->request('DELETE', $path, $options);
    }

    public function testHomePage()
    {
        $this->get('/');
        $this->assertEquals('200', $this->response->status());
    }
    /**
     * @covers class::()
     */
    public function testGetAll()
    {
        $this->get('/emojis');
        $this->assertEquals('200', $this->response->status());
    }

    /**
     * @covers class::()
     */
    public function testFindEmoji()
    {
        $this->get('/emojis/1');
        $this->assertEquals('200', $this->response->status());
    }

    /**
     * @covers class::()
     */
    public function testCreateEmoji()
    {
        $this->post('/emojis/1');
        $this->assertEquals('200', $this->response->status());
    }

    /**
     * @covers class::()
     */
    public function testUpdateEmoji()
    {
        $this->patch('/emojis/1');
        $this->assertEquals('200', $this->response->status());
    }

    /**
     * @covers class::()
     */
    public function testPutEmoji()
    {
        $this->put('/emojis/1');
        $this->assertEquals('200', $this->response->status());
    }

    /**
     * @covers class::()
     */
    public function testDeleteEmoji()
    {
        $this->delete('/emojis/1');
        $this->assertEquals('200', $this->response->status());
    }
}