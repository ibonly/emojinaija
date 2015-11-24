<?php
namespace Ibonly\NaijaEmoji;

use Slim\Slim;
use Ibonly\NaijaEmoji\User;
use Ibonly\NaijaEmoji\AuthController;
use Ibonly\PotatoORM\UserNotFoundException;
/**
*
*/
class UserController
{
    protected $user;
    protected $auth;

    public function __construct()
    {
        $this->user = new User();
        $this->auth = new AuthController();
    }

    public function createUser (Slim $app)
    {
        $username = $app->request->params('username');
        $this->user->id = NULL;
        $this->user->username = $username;
        $this->user->password = $app->request->params('password');

        $save = $this->user->save();
        if( $save == 1 )
        {
            $app->halt(201, json_encode(['message' => 'Created']));
        }
    }

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
                    $output = $key->username;
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

    public function logout (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ExpiredException();

            $checkUser = $this->user->where(['username' => $tokenData->user])->all();
            if( ! empty ($checkUser) ){
                $this->auth->authorizationEncode(NULL);
                $app->halt(200, json_encode(['message' => 'Logged out Successfully']));
            }
        } catch ( UserNotFoundException $e) {
            $app->halt(404, json_encode(['message' => 'Not Found']));
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        }
    }
}