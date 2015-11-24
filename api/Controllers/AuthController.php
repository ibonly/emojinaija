<?php
namespace Ibonly\NaijaEmoji;

use Slim\Slim;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Ibonly\NaijaEmoji\User;
/**
*
*/
class AuthController
{
    protected $key;
    protected $userID;
    protected $auth_url;
    protected $issued_by;

    public function __construct ()
    {
        $this->loadEnv();
        $this->key = getenv('TOKEN_KEY');
        $this->issued_by = getenv('ISSUED_BY');
        $this->auth_url = getenv('AUTH_URL');
    }

    public function getKey ()
    {
        return $this->key;
    }

    public function issuedBy()
    {
        return $this->issued_by;
    }

    public function authUrl()
    {
        return $this->auth_url;
    }

    public function authorizationEncode ($username)
    {
        if ( ! is_null($username) )
            $token = array(
                "iss" => $this->issuedBy(),
                "aud" => $this->authUrl(),
                "user" => $username,
                "exp" => time() + 3600
            );
            return JWT::encode($token, $this->getKey());
    }

    public function authorizationDecode ($jwt)
    {
        return JWT::decode($jwt, $this->getKey(), array('HS256'));
    }

    protected function loadEnv ()
    {
        if( ! getenv("APP_ENV" !== "production"))
        {
            $dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
            $dotenv->load();
        }
    }
}