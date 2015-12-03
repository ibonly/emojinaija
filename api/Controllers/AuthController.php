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
        $this->test_token = getenv('TEST_TOKEN');
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
    public function getIssuedBy ()
    {
        return $this->issued_by;
    }

    /**
     * getAuthUrl Get the AUTH_URL value
     *
     * @return string
     */
    public function getAuthUrl ()
    {
        return $this->auth_url;
    }

    /**
     * getAuthUrl Get the TEST_TOKEN value
     *
     * @return string
     */
    public function getTestToken ()
    {
        return $this->test_token;
    }

    /**
     * authorizationEncode Generate token using $userID
     *
     * @param  $userID
     *
     * @return string
     */
    public function authorizationEncode ($userID)
    {
        if ( ! is_null($userID) )
            $token = array(
                "iss" => $this->getIssuedBy(),
                "aud" => $this->getAuthUrl(),
                "user" => $userID,
                "exp" => time() + 3600000
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

    /**
     * Encrypt user password
     *
     * @param  $password
     *
     * @return string
     */
    public function passwordEncrypt ($password)
    {
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Decrypt user password
     *
     * @param  $password
     *
     * @return bool
     */
    public function passwordDecrypt ($password, $hashPassword)
    {
        if ( password_verify($password, $hashPassword) )
        {
            return true;
        }
        throw new PasswordException();
    }

    /**
     * Load .env data
     */
    protected function loadEnv ()
    {
        if ( ! getenv("APP_ENV"))
        {
            $dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
            $dotenv->load();
        }
    }
}
