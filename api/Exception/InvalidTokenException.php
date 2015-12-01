<?php

/**
 * Exception for no records in database
 *
 * @package Ibonly\NaijaEmoji\EmptyDatabaseException
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Exception;

class InvalidTokenException extends Exception
{
    public function __construct ()
    {
        parent::__construct("Invalid Token");
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function errorMessage ()
    {
        return json_encode(['status' => '401', 'Message' => $this->getMessage()]);
    }
}