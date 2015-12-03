<?php

/**
 * GetEnv gets the declared variables from .env file
 *
 * @package Ibonly\NaijaEmoji\GetEnv
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Dotenv\Dotenv;

class GetEnv implements GetEnvInterface
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

    protected function loadEnv ()
    {
        if ( ! getenv("APP_ENV"))
        {
            $dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
            $dotenv->load();
        }
    }
}
