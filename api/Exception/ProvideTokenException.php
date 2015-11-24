<?php
/**
 * Exception to provide token
 *
 * @package Ibonly\NaijaEmoji\ProvideTokenException
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Exception;

class ProvideTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct("Enter your Token");
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function errorMessage()
    {
        return json_encode(['status' => '401', 'Message' => $this->getMessage()]);
    }
}