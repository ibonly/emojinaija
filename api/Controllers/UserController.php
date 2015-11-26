<?php

/**
 * UserController Managers user activity login, register and logout
 *
 * @package Ibonly\NaijaEmoji\UserController
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Slim\Slim;
use Ibonly\NaijaEmoji\User;
use Ibonly\NaijaEmoji\UserInterface;
use Ibonly\NaijaEmoji\AuthController;
use Ibonly\PotatoORM\UserNotFoundException;
use Ibonly\NaijaEmoji\InvalidTokenException;
use Ibonly\NaijaEmoji\ProvideTokenException;

class UserController implements UserInterface
{
    protected $user;
    protected $auth;

    public function __construct()
    {
        $this->user = new User();
        $this->auth = new AuthController();
    }

    /**
     * createUser Create a new user
     *
     * @param  $app
     *
     * @return json
     */
    public function createUser (Slim $app)
    {
        $username = $app->request->params('username');
        $this->user->id = NULL;
        $this->user->username = $username;
        $this->user->password = $app->request->params('password');
        $this->user->date_created = date('Y-m-d H:i:s');

        $save = $this->user->save();
        if( $save == 1 )
        {
            $app->halt(201, json_encode(['message' => 'Created']));
        }
    }

    /**
     * login Log user in and generate token
     *
     * @param  $app
     *
     * @return json
     */
    public function login (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $username = $app->request->params('username');
        $password = $app->request->params('password');
        try
        {
            $login = $this->user->where(['username' => $username, 'password' => $password], 'AND')->all();
            if( ! empty ($login) ){
                $output = json_decode($login);
                foreach ($output as $key) {
                    $output = $key->id;
                }
                return(json_encode([
                    'Username' => $username,
                    'Authorization' => $this->auth->authorizationEncode($username)
                ]));
            }
        } catch ( UserNotFoundException $e) {
            $app->halt(404, json_encode(['message' => 'Not Found']));
        }
    }

    /**
     * logout Log user out and destroy token
     *
     * @param  $app
     *
     * @return json
     */
    public function logout (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ProvideTokenException();

            $checkUser = $this->user->where(['username' => $tokenData->user])->all();
            if( ! empty ($checkUser) ){
                $this->auth->authorizationEncode(NULL);
                $app->halt(200, json_encode(['message' => 'Logged out Successfully']));
            }
        } catch ( UserNotFoundException $e) {
            $app->halt(404, json_encode(['message' => 'Not Found']));
        } catch ( InvalidTokenException $e ){
            $app->halt(405, json_encode(['Message' => 'Invalid Token']));
        } catch ( ProvideTokenException $e ){
            $app->halt(406, json_encode(['Message' => 'Enter a valid Token']));
        }
    }
}