<?php
namespace Ibonly\NaijaEmoji;

use Slim\Slim;
use Firebase\JWT\JWT;
use Ibonly\NaijaEmoji\User;
/**
*
*/
class AuthController
{
    protected $key;
    protected $userID;

    public function __construct()
    {
        $this->key = "example_key";
    }
    public function getKey()
    {
        return $this->key;
    }

    public function authorizationEncode($username)
    {
        if ( ! is_null($username) )
            $token = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "user" => $username,
                "exp" => time() + 3600
            );
            return JWT::encode($token, $this->getKey());
    }

    public function authorizationDecode($jwt)
    {
        return JWT::decode($jwt, $this->getKey(), array('HS256'));
    }
}