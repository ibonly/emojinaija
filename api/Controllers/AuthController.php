<?php

/**
 * AuthController manages the authentication i.e generation of token
 *
 * @package Ibonly\NaijaEmoji\AuthController
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Exception;
use Slim\Slim;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Ibonly\NaijaEmoji\User;
use Ibonly\NaijaEmoji\AuthInterface;
use Ibonly\NaijaEmoji\InvalidTokenException;

class AuthController implements AuthInterface
{
    protected $key;
    protected $userID;
    protected $auth_url;
    protected $issued_by;

    public function __construct ()
    {
        $this->loadEnv();
        $this->key        = getenv('ISSUE_KEY');
        $this->issued_by  = getenv('ISSUED_BY');
        $this->auth_url   = getenv('AUTH_URL');
    }

    /**
     * getKey Get the ISSUE_KEY value
     *
     * @return string
     */
    public function getKey ()
    {
        return $this->key;
    }

    /**
     * getIssuedBy Get the ISSUED_BY value
     *
     * @return string
     */
    public function getIssuedBy()
    {
        return $this->issued_by;
    }

    /**
     * getAuthUrl Get the AUTH_URL value
     *
     * @return string
     */
    public function getAuthUrl()
    {
        return $this->auth_url;
    }

    /**
     * authorizationEncode Generate token using $username
     *
     * @param  $username
     *
     * @return string
     */
    public function authorizationEncode ($username)
    {
        if ( ! is_null($username) )
            $token = array(
                "iss" => $this->getIssuedBy(),
                "aud" => $this->getAuthUrl(),
                "user" => $username,
                "exp" => time() + 3600
            );
            return JWT::encode($token, $this->getKey());
    }

    /**
     * authorizationDecode Decode token
     *
     * @param  $token
     *
     * @return json
     */
    public function authorizationDecode ($token)
    {
        try
        {
            return JWT::decode($token, $this->getKey(), array('HS256'));
        } catch ( Exception $e) {
            throw new InvalidTokenException();
        }

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